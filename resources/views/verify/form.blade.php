{{-- resources/views/verify/form.blade.php --}}
@extends('layouts.app')

@section('title', 'التحقق من شهادة')

@section('content')

<div class="max-w-3xl mx-auto bg-white border border-gray-200 rounded-xl shadow p-10">

    <!-- Title -->
    <div class="text-center mb-10">
        <h2 class="text-3xl font-extrabold text-[#0D1B2A] mb-3">
            التحقق من صحة الشهادة الجامعية
        </h2>
        <p class="text-gray-600 text-sm leading-relaxed">
            قم بإدخال رقم الشهادة للتحقق الفوري من صحتها عبر النظام القومي
        </p>
    </div>

    <!-- Errors -->
    @if(session('error'))
        <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-center font-medium">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('verify.post') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block text-[#0D1B2A] font-semibold mb-2">رقم الشهادة</label>
            <input 
                type="text" 
                name="certificate_number" 
                placeholder="مثال: CERT-2024-002135" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#0D1B2A] focus:border-[#0D1B2A] transition"
                required
                autofocus
            >
        </div>

        <button type="submit" 
            class="w-full bg-[#0D1B2A] text-white py-3 text-lg rounded-lg font-semibold hover:bg-[#132238] transition shadow">
             تحقق الآن
        </button>
    </form>

    <!-- QR Section -->
    <div class="mt-10 pt-8 border-t border-gray-200 text-center">
        <button onclick="startQRScan()" 
            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-lg transition font-medium">
             مسح رمز QR
        </button>

        <p class="text-sm text-gray-500 mt-3">
            يمكنك استخدام كاميرا الهاتف أو جهاز الكمبيوتر للمسح
        </p>
    </div>

    <!-- Security Note -->
    <div class="mt-8 bg-blue-50 border border-blue-200 px-4 py-4 rounded-lg text-blue-800 text-sm">
        🔒 جميع عمليات التحقق تتم عبر قناة اتصال مشفرة وآمنة وفق المعايير الحكومية.
    </div>
</div>

@push('scripts')
<script>
function startQRScan() {
    alert('ميزة مسح رمز QR ستتم إضافتها في الإصدار القادم.');
}
</script>
@endpush

@endsection
