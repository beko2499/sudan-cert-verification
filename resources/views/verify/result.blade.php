{{-- resources/views/verify/result.blade.php --}}
@extends('layouts.app')

@section('title', 'نتيجة التحقق')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- رسالة نجاح رسمية بصورة المصافحة --}}

    {{-- بطاقة تفاصيل الشهادة --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">

        {{-- شريط التحقق + QR داخل البطاقة --}}
        <div class="bg-green-50 border-2 border-green-500 rounded-xl p-5 mb-6 flex flex-row items-center">
            {{-- QR يمين --}}
            @if($certificate->qr_code)
                <img src="{{ asset('storage/' . $certificate->qr_code) }}" alt="QR Code" class="w-28 h-28 border-2 border-green-200 rounded-lg bg-white p-1">
            @endif

            {{-- النص في المنتصف --}}
            <div class="flex-1 text-center px-4">
                <h2 class="text-2xl font-extrabold text-green-800">الشهادة معتمدة</h2>
                <p class="text-green-700 mt-1">تم التحقق من صحة هذه الشهادة بنجاح.</p>
                @if($certificate->qr_code)
                    <p class="text-xs text-green-600 mt-2">رمز التحقق السريع (QR)</p>
                @endif
            </div>

            {{-- أيقونة معتمدة يسار وكبيرة --}}
            <img src="{{ asset('images/معتمدة.jpg') }}" alt="تم التحقق" class="w-24 h-24 object-contain">
        </div>

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

        {{-- الأزرار --}}
        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap gap-3 justify-center">
            @if($certificate->pdf_file)
                <a href="{{ asset('storage/' . $certificate->pdf_file) }}"
                   class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700"
                   target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg> تحميل PDF
                </a>
            @endif

            <button onclick="shareLink()" class="bg-gray-700 text-white px-6 py-2 rounded-lg hover:bg-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg> مشاركة رابط التحقق
            </button>

            <a href="{{ route('verify') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg> تحقق من شهادة أخرى
            </a>
        </div>
    </div>

    {{-- تنبيه --}}
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <p class="text-sm text-yellow-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> هذه الشهادة معتمدة من النظام القومي للتحقق. للاستفسار يُرجى التواصل مع الجامعة المصدِّرة.
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
