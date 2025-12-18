<?php
// app/Http/Controllers/AdminDashboardController.php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Certificate;
use App\Models\University;
use App\Models\User;
use App\Models\VerificationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    /**
     * لوحة تحكم الإدارة الرئيسية
     */
    public function index()
    {
        $stats = [
            'total_universities' => University::count(),
            'active_universities' => University::where('is_active', true)->count(),
            'total_certificates' => Certificate::count(),
            'verified_certificates' => Certificate::where('status', 'verified')->count(),
            'pending_certificates' => Certificate::where('status', 'pending')->count(),
            'total_verifications' => VerificationLog::count(),
            'verifications_this_month' => VerificationLog::whereMonth('created_at', now()->month)->count(),
        ];
        
        // أكثر الجامعات نشاطاً
        $activeUniversities = University::withCount('certificates')
            ->orderBy('certificates_count', 'desc')
            ->take(5)
            ->get();
        
        // آخر عمليات التحقق
        $recentVerifications = VerificationLog::with('certificate.university')
            ->latest()
            ->take(10)
            ->get();
        
        return view('admin.dashboard', compact('stats', 'activeUniversities', 'recentVerifications'));
    }
    
    /**
     * عرض نموذج إضافة جامعة
     */
    public function create()
    {
        return view('admin.universities.create');
    }
    
    /**
     * حفظ جامعة جديدة
     */
    public function store(Request $request)
    {
        // ✅ تحقق المدخلات قبل أي إدراج
        $validated = $request->validate([
            // جامعة
            'name_ar'   => ['required','string','max:255'],
            'name_en'   => ['required','string','max:255'],
            'code'      => ['required','string','max:10', Rule::unique('universities','code')],
            'email'     => ['nullable','email', Rule::unique('universities','email')], // إيميل الجامعة (اختياري)
            'phone'     => ['nullable','string','max:50'],
            'address'   => ['nullable','string','max:500'],
            'logo'      => ['nullable','image','mimes:jpg,jpeg,png','max:2048'],
            'is_active' => ['nullable','boolean'],

            // مدير الجامعة (مطلوب على الأقل الإيميل لتكوين مستخدم)
            'manager_name'  => ['required','string','max:255'],
            'manager_email' => ['required','email', Rule::unique('users','email')],
            'manager_password' => ['nullable','string','min:8'], // اختياري، وإلا بنحط افتراضي
        ],[
            'manager_name.required'  => 'الرجاء إدخال اسم مدير الجامعة',
            'manager_email.required' => 'الرجاء إدخال بريد مدير الجامعة',
            'manager_email.unique'   => 'بريد مدير الجامعة مستخدم من قبل',
        ]);

        // حول check-box
        $validated['is_active'] = $request->boolean('is_active');

        // ارفع الشعار إن وجد
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('universities/logos', 'public');
            $validated['logo'] = $path;
        }

        // نفذ بترانزاكشن: جامعة + مستخدم
        return DB::transaction(function () use ($validated) {

            // ❗️ مافي تكرار create — سطر واحد فقط
            $university = University::create([
                'name_ar'   => $validated['name_ar'],
                'name_en'   => $validated['name_en'],
                'code'      => $validated['code'],
                'email'     => $validated['email'] ?? null,
                'phone'     => $validated['phone'] ?? null,
                'address'   => $validated['address'] ?? null,
                'logo'      => $validated['logo'] ?? null,
                'is_active' => $validated['is_active'],
            ]);

            // كوّن مستخدم مدير للجامعة
            $password = $validated['manager_password'] ?? 'password123';

            $adminUser = User::create([
                'name'         => $validated['manager_name'],
                'email'        => $validated['manager_email'],
                'password'     => Hash::make($password),
                'university_id'=> $university->id,
            ]);

            // عيّن دور مدير جامعة
            if (method_exists($adminUser, 'assignRole')) {
                $adminUser->assignRole('university_admin');
            }

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'تمت إضافة الجامعة ومديرها بنجاح.');
        });
    }
    /**
     * عرض جامعة محددة
     */
    public function show(University $university)
    {
        $university->load(['certificates' => function($q) {
            $q->latest()->take(20);
        }]);
        
        $stats = [
            'total_certificates' => $university->certificates()->count(),
            'verified' => $university->certificates()->where('status', 'verified')->count(),
            'pending' => $university->certificates()->where('status', 'pending')->count(),
            'suspended' => $university->certificates()->where('status', 'suspended')->count(),
        ];
        
        return view('admin.universities.show', compact('university', 'stats'));
    }
    
    /**
     * عرض نموذج تعديل جامعة
     */
    public function edit(University $university)
    {
        return view('admin.universities.edit', compact('university'));
    }
    
    /**
     * تحديث بيانات جامعة
     */
    public function update(Request $request, University $university)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:universities,code,' . $university->id,
            'email' => 'required|email|unique:universities,email,' . $university->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);
        
        if ($request->hasFile('logo')) {
            // حذف الشعار القديم
            if ($university->logo) {
                Storage::disk('public')->delete($university->logo);
            }
            $validated['logo'] = $request->file('logo')->store('universities/logos', 'public');
        }
        
        $university->update($validated);
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'تم تحديث بيانات الجامعة بنجاح');
    }
    
    /**
     * حذف جامعة
     */
    public function destroy(University $university)
    {
        if ($university->certificates()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف الجامعة لوجود شهادات مرتبطة بها');
        }
        
        // حذف الشعار
        if ($university->logo) {
            Storage::disk('public')->delete($university->logo);
        }
        
        $university->delete();
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'تم حذف الجامعة بنجاح');
    }
    
    /**
     * عرض الإحصائيات التفصيلية
     */
    public function statistics()
    {
        $monthlyStats = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyStats[] = [
                'month' => $date->format('Y-m'),
                'month_name' => $date->locale('ar')->translatedFormat('F Y'),
                'certificates' => Certificate::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'verifications' => VerificationLog::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        
        $universityStats = University::withCount([
            'certificates',
            'certificates as verified_count' => function($q) {
                $q->where('status', 'verified');
            }
        ])->get();
        
        return view('admin.statistics', compact('monthlyStats', 'universityStats'));
    }
    
    /**
     * عرض الشهادات المشتبه بها
     */
    public function suspicious()
    {
        // الشهادات التي تم التحقق منها أكثر من 10 مرات في يوم واحد
        $suspiciousCerts = Certificate::withCount([
            'verificationLogs as today_verifications' => function($q) {
                $q->whereDate('created_at', today());
            }
        ])
        ->with('university')
        ->get()
        ->filter(function($cert) {
            return $cert->today_verifications > 10;
        });
        
        // شهادات قيد المراجعة لفترة طويلة
        $pendingCerts = Certificate::where('status', 'pending')
            ->where('created_at', '<', now()->subDays(7))
            ->with('university')
            ->get();
        
        return view('admin.suspicious', compact('suspiciousCerts', 'pendingCerts'));
    }
    
    /**
     * عرض سجل عمليات التحقق
     */
    public function logs()
    {
        $logs = VerificationLog::with('certificate.university')
            ->latest()
            ->paginate(50);
        
        return view('admin.logs', compact('logs'));
    }
}