{{-- resources/views/university/certificates/show.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'عرض الشهادة')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">بيانات الشهادة</h1>
            <p class="text-gray-600 mt-2">رقم الشهادة: <span class="font-semibold text-primary-700">{{ $certificate->certificate_number }}</span></p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('university.certificates.edit', $certificate) }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> تعديل
            </a>
            <a href="{{ route('university.dashboard') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                ← العودة
            </a>
        </div>
    </div>

    {{-- حالة الشهادة --}}
    <div class="mb-6">
        @if($certificate->status === 'verified')
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> معتمدة
            </span>
        @elseif($certificate->status === 'pending')
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                ⏳ قيد المراجعة
            </span>
        @else
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> موقوفة
            </span>
        @endif
    </div>

    {{-- بطاقة تفاصيل الشهادة --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="grid md:grid-cols-2 gap-8">
            {{-- معلومات الطالب --}}
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">معلومات الطالب</h3>
                <div class="space-y-4">
                    <div>
                        <span class="text-gray-500 text-sm">الاسم بالعربية:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->student_name_ar }}</p>
                    </div>
                    @if($certificate->student_name_en)
                    <div>
                        <span class="text-gray-500 text-sm">الاسم بالإنجليزية:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->student_name_en }}</p>
                    </div>
                    @endif
                    <div>
                        <span class="text-gray-500 text-sm">الرقم الجامعي:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->student_id }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">التقدير:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->grade }}</p>
                    </div>
                    @if($certificate->gpa)
                    <div>
                        <span class="text-gray-500 text-sm">المعدل التراكمي:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->gpa }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- معلومات الشهادة --}}
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">معلومات الشهادة</h3>
                <div class="space-y-4">
                    <div>
                        <span class="text-gray-500 text-sm">الكلية:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->faculty_ar }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">البرنامج الدراسي:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->program_ar }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">سنة التخرج:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->graduation_year }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm">تاريخ الإصدار:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->issue_date ? \Carbon\Carbon::parse($certificate->issue_date)->format('Y-m-d') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- QR Code --}}
        @if($certificate->qr_code)
        <div class="mt-8 pt-8 border-t border-gray-200 text-center">
            <h3 class="text-lg font-bold text-gray-900 mb-4">رمز التحقق السريع (QR)</h3>
            <img src="{{ asset('storage/' . $certificate->qr_code) }}" alt="QR Code" class="mx-auto w-40 h-40">
            <p class="text-sm text-gray-500 mt-2">امسح الرمز للتحقق من صحة الشهادة</p>
        </div>
        @endif

        {{-- رابط التحقق العام --}}
        <div class="mt-8 pt-8 border-t border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">رابط التحقق العام</h3>
            <div class="flex items-center gap-3 bg-gray-50 p-4 rounded-lg">
                <input type="text" 
                       value="{{ url('/certificate/' . $certificate->certificate_number) }}" 
                       class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm"
                       readonly
                       id="verification-url">
                <button onclick="copyUrl()" 
                        class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg> نسخ
                </button>
            </div>
        </div>

        {{-- ملف PDF --}}
        @if($certificate->pdf_file)
        <div class="mt-8 pt-8 border-t border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">ملف الشهادة</h3>
            <a href="{{ asset('storage/' . $certificate->pdf_file) }}" 
               target="_blank"
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg> تحميل نسخة PDF
            </a>
        </div>
        @endif

        {{-- ملاحظات --}}
        @if($certificate->notes)
        <div class="mt-8 pt-8 border-t border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4">ملاحظات</h3>
            <p class="text-gray-700">{{ $certificate->notes }}</p>
        </div>
        @endif
    </div>

    {{-- معلومات إضافية --}}
    <div class="mt-6 bg-gray-50 rounded-lg p-4 text-sm text-gray-600">
        <div class="flex justify-between">
            <span>تاريخ الإنشاء: {{ $certificate->created_at->format('Y-m-d H:i') }}</span>
            <span>آخر تحديث: {{ $certificate->updated_at->format('Y-m-d H:i') }}</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyUrl() {
    const input = document.getElementById('verification-url');
    input.select();
    document.execCommand('copy');
    alert('تم نسخ الرابط!');
}
</script>
@endpush
@endsection
