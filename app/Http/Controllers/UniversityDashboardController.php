<?php



namespace App\Http\Controllers;


use App\Models\Certificate;
use App\Models\VerificationLog;
use App\Services\QRCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class UniversityDashboardController extends Controller
{
    protected $qrCodeService;
    
    public function __construct(QRCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }
    
    /**
     * لوحة تحكم الجامعة - الصفحة الرئيسية
     */
    public function index()
    {
        $university = Auth::user()->university;
        
        $stats = [
            'total' => Certificate::where('university_id', $university->id)->count(),
            'verified' => Certificate::where('university_id', $university->id)
                ->where('status', 'verified')->count(),
            'pending' => Certificate::where('university_id', $university->id)
                ->where('status', 'pending')->count(),
            'suspended' => Certificate::where('university_id', $university->id)
                ->where('status', 'suspended')->count(),
            'verifications' => VerificationLog::whereHas('certificate', function($q) use ($university) {
                $q->where('university_id', $university->id);
            })->whereMonth('created_at', now()->month)->count(),
        ];
        
        $recentCertificates = Certificate::where('university_id', $university->id)
            ->latest()
            ->take(10)
            ->get();
        
        return view('university.dashboard', compact('stats', 'recentCertificates'));
    }
    
    /**
     * عرض جميع الشهادات مع البحث والفلترة
     */
    public function certificatesIndex(Request $request)
    {
        $university = Auth::user()->university;
        
        $query = Certificate::where('university_id', $university->id);
        
        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('certificate_number', 'like', "%{$search}%")
                  ->orWhere('student_name_ar', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }
        
        // الفلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // الإحصائيات
        $stats = [
            'total' => Certificate::where('university_id', $university->id)->count(),
            'verified' => Certificate::where('university_id', $university->id)->where('status', 'verified')->count(),
            'pending' => Certificate::where('university_id', $university->id)->where('status', 'pending')->count(),
            'suspended' => Certificate::where('university_id', $university->id)->where('status', 'suspended')->count(),
        ];
        
        $certificates = $query->latest()->paginate(20);
        
        return view('university.certificates.index', compact('certificates', 'stats'));
    }
    
    /**
     * عرض نموذج إضافة شهادة
     */
    public function create()
    {
        return view('university.certificates.create');
    }
    
    /**
     * حفظ شهادة جديدة
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name_ar' => 'required|string|max:255',
            'student_name_en' => 'nullable|string|max:255',
            'student_id' => 'required|string|max:100',
            'program_ar' => 'required|string|max:255',
            'program_en' => 'nullable|string|max:255',
            'faculty_ar' => 'required|string|max:255',
            'faculty_en' => 'nullable|string|max:255',
            'graduation_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'grade' => 'required|string',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'issue_date' => 'required|date',
            'pdf_file' => 'nullable|file|mimes:pdf|max:5120',
            'notes' => 'nullable|string',
        ]);
        
        // إنشاء رقم شهادة فريد
        $validated['certificate_number'] = $this->generateCertificateNumber();
        $validated['university_id'] = Auth::user()->university_id;
        $validated['status'] = 'verified';
        
        // رفع ملف PDF
        if ($request->hasFile('pdf_file')) {
            $validated['pdf_file'] = $request->file('pdf_file')->store('certificates/pdfs', 'public');
        }
        
        $certificate = Certificate::create($validated);
        
        // إنشاء QR Code
        $qrPath = $this->qrCodeService->generate($certificate);
        $certificate->update(['qr_code' => $qrPath]);
        
        return redirect()->route('university.dashboard')
            ->with('success', 'تم إضافة الشهادة بنجاح');
    }
    
    /**
     * عرض شهادة محددة
     */
    public function show(Certificate $certificate)
    {
        // التأكد من أن الشهادة تابعة للجامعة الحالية
        if ($certificate->university_id !== Auth::user()->university_id) {
            abort(403, 'غير مصرح لك بالوصول لهذه الشهادة');
        }
        
        return view('university.certificates.show', compact('certificate'));
    }
    
    /**
     * عرض نموذج تعديل شهادة
     */
    public function edit(Certificate $certificate)
    {
        // التأكد من أن الشهادة تابعة للجامعة الحالية
        if ($certificate->university_id !== Auth::user()->university_id) {
            abort(403, 'غير مصرح لك بالوصول لهذه الشهادة');
        }
        
        return view('university.certificates.edit', compact('certificate'));
    }
    
    /**
     * تحديث شهادة
     */
    public function update(Request $request, Certificate $certificate)
    {
        // التأكد من أن الشهادة تابعة للجامعة الحالية
        if ($certificate->university_id !== Auth::user()->university_id) {
            abort(403, 'غير مصرح لك بتعديل هذه الشهادة');
        }
        
        $validated = $request->validate([
            'student_name_ar' => 'required|string|max:255',
            'student_name_en' => 'nullable|string|max:255',
            'student_id' => 'required|string|max:100',
            'program_ar' => 'required|string|max:255',
            'faculty_ar' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'grade' => 'required|string',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'issue_date' => 'required|date',
            'pdf_file' => 'nullable|file|mimes:pdf|max:5120',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:pending,verified,suspended',
        ]);
        
        // رفع ملف PDF جديد
        if ($request->hasFile('pdf_file')) {
            // حذف الملف القديم
            if ($certificate->pdf_file) {
                Storage::disk('public')->delete($certificate->pdf_file);
            }
            $validated['pdf_file'] = $request->file('pdf_file')->store('certificates/pdfs', 'public');
        }
        
        $certificate->update($validated);
        
        return redirect()->route('university.certificates.index')
            ->with('success', 'تم تحديث الشهادة بنجاح');
    }
    
    /**
     * حذف شهادة
     */
    public function destroy(Certificate $certificate)
    {
        // التأكد من أن الشهادة تابعة للجامعة الحالية
        if ($certificate->university_id !== Auth::user()->university_id) {
            abort(403, 'غير مصرح لك بحذف هذه الشهادة');
        }
        
        // حذف الملفات المرتبطة
        if ($certificate->pdf_file) {
            Storage::disk('public')->delete($certificate->pdf_file);
        }
        if ($certificate->qr_code) {
            Storage::disk('public')->delete($certificate->qr_code);
        }
        
        $certificate->delete();
        
        return redirect()->route('university.certificates.index')
            ->with('success', 'تم حذف الشهادة بنجاح');
    }
    
    /**
     * عرض سجلات التحقق
     */
    public function logs()
    {
        $university = Auth::user()->university;
        
        $logs = VerificationLog::whereHas('certificate', function($q) use ($university) {
            $q->where('university_id', $university->id);
        })
        ->with('certificate')
        ->latest()
        ->paginate(50);
        
        return view('university.logs', compact('logs'));
    }
    
    /**
     * تصدير البيانات
     */
    public function export(Request $request)
    {
        $university = Auth::user()->university;
        $format = $request->get('format', 'xlsx'); // xlsx أو pdf
        
        $certificates = Certificate::where('university_id', $university->id)->get();
        
        if ($format === 'pdf') {
            return $this->exportPDF($certificates, $university);
        }
        
        return Excel::download(
            new \App\Exports\CertificatesExport($certificates),
            'certificates-' . date('Y-m-d') . '.xlsx'
        );
    }
    
    /**
     * إنشاء رقم شهادة فريد
     */
    private function generateCertificateNumber()
    {
        $university = Auth::user()->university;
        $year = date('Y');
        $prefix = $university->code . '-' . $year . '-';
        
        // البحث عن آخر رقم شهادة لهذه السنة (بما في ذلك المحذوفة)
        $lastCertificate = Certificate::withTrashed()
            ->where('university_id', $university->id)
            ->where('certificate_number', 'like', $prefix . '%')
            ->orderByRaw("CAST(SUBSTR(certificate_number, -6) AS INTEGER) DESC")
            ->first();
        
        if ($lastCertificate) {
            // استخراج الرقم من آخر شهادة وزيادته
            $lastNumber = (int) substr($lastCertificate->certificate_number, -6);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return sprintf('%s%06d', $prefix, $newNumber);
    }
    
    /**
     * تصدير PDF
     */
    private function exportPDF($certificates, $university)
    {
        $pdf = Pdf::loadView('university.exports.pdf', compact('certificates', 'university'));
        return $pdf->download('certificates-' . date('Y-m-d') . '.pdf');
    }
}