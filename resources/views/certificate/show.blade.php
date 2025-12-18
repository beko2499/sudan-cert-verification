{{-- resources/views/certificate/show.blade.php --}}
@extends('layouts.app')

@section('title', 'تفاصيل الشهادة - ' . $certificate->certificate_number)

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- رسالة نجاح رسمية بصورة المصافحة --}}
    <div class="bg-green-50 border-2 border-green-500 rounded-xl p-6 mb-8">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/معتمدة.jpg') }}" alt="تم التحقق" class="w-20 h-20 object-contain">
            <div>
                <h2 class="text-2xl font-extrabold text-green-800">الشهادة معتمدة</h2>
                <p class="text-green-700">تم التحقق من صحة هذه الشهادة بنجاح.</p>
            </div>
        </div>
    </div>

    {{-- بطاقة تفاصيل الشهادة --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="grid md:grid-cols-2 gap-6">
            {{-- معلومات الطالب --}}
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">معلومات الطالب</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-600 text-sm">الاسم:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->student_name_ar }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm">الرقم الجامعي:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->student_id }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm">التقدير:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->grade }}</p>
                    </div>
                    @if($certificate->gpa)
                        <div>
                            <span class="text-gray-600 text-sm">المعدل التراكمي:</span>
                            <p class="font-medium text-gray-900">{{ $certificate->gpa }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- معلومات الشهادة --}}
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b">معلومات الشهادة</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-gray-600 text-sm">الجامعة:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->university->name_ar }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm">الكلية:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->faculty_ar }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm">البرنامج الدراسي:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->program_ar }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm">سنة التخرج:</span>
                        <p class="font-medium text-gray-900">{{ $certificate->graduation_year }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm">رقم الشهادة:</span>
                        <p class="font-semibold text-primary-700">{{ $certificate->certificate_number }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- QR --}}
        @if($certificate->qr_code)
            <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                <img src="{{ asset('storage/' . $certificate->qr_code) }}" alt="QR Code" class="mx-auto w-32 h-32">
                <p class="text-sm text-gray-600 mt-2">رمز التحقق السريع</p>
            </div>
        @endif

        {{-- الأزرار --}}
        <div class="mt-8 flex flex-wrap gap-3 justify-center">
            @if($certificate->pdf_file)
                <a href="{{ asset('storage/' . $certificate->pdf_file) }}"
                   class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700"
                   target="_blank">
                    📄 تحميل PDF
                </a>
            @endif

            <button onclick="shareLink()" class="bg-gray-700 text-white px-6 py-2 rounded-lg hover:bg-gray-800">
                🔗 مشاركة رابط التحقق
            </button>

            <a href="{{ route('verify') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300">
                ↩️ تحقق من شهادة أخرى
            </a>
        </div>
    </div>

    {{-- تنبيه --}}
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <p class="text-sm text-yellow-800">
            ⚠️ هذه الشهادة معتمدة من النظام القومي للتحقق. للاستفسار يُرجى التواصل مع الجامعة المصدِّرة.
        </p>
    </div>
</div>

@push('scripts')
<script>
function shareLink() {
    const url = "{{ $certificate->verification_url }}";
    if (navigator.share) {
        navigator.share({ title: 'رابط التحقق من الشهادة', url });
    } else {
        navigator.clipboard.writeText(url);
        alert('تم نسخ الرابط إلى الحافظة');
    }
}
</script>
@endpush
@endsection
