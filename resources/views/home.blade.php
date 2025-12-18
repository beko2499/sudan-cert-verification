{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'الصفحة الرئيسية')

@section('content')

<!-- Hero Section -->
<div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-200">
    <h1 class="text-4xl md:text-5xl font-extrabold text-[#0D1B2A] mb-4">
        مرحباً بك في النظام القومي للتحقق من الشهادات الجامعية
    </h1>

    <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed mb-8">
        منصة حكومية معتمدة تسهّل التحقق الفوري من صحة الشهادات الجامعية
        للحد من التزوير وتعزيز الثقة بين المؤسسات والخريجين.
    </p>

    <div class="flex flex-col md:flex-row justify-center gap-4">
        <a href="{{ route('verify') }}" class="px-10 py-4 text-lg bg-[#0D1B2A] text-white font-semibold rounded-lg hover:bg-[#132238] transition shadow-md">
              التحقق الآن
        </a>
        <a href="{{ route('contact') }}" class="px-10 py-4 text-lg border-2 border-[#0D1B2A] text-[#0D1B2A] font-semibold rounded-lg hover:bg-[#0D1B2A] hover:text-white transition shadow-md">
             تواصل معنا
        </a>
    </div>
</div>

<!-- Features Section -->
<div class="my-20">
    <h2 class="text-center text-3xl font-extrabold text-[#0D1B2A] mb-12">
        لماذا هذا النظام؟
    </h2>

    <div class="grid md:grid-cols-3 gap-8">

        <div class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition p-8 text-center">
            <div class="flex justify-center mb-4">
    <img src="{{ asset('images/رسمية.jpg') }}" alt="Handshake" class="h-20 w-auto">
</div>
            <h3 class="text-xl font-bold text-[#0D1B2A] mb-2">موثوقية رسمية</h3>
            <p class="text-gray-600 text-sm leading-relaxed">
                النظام معتمد من وزارة التعليم العالي لضمان صحة الشهادات.
            </p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition p-8 text-center">
            <div class="flex justify-center mb-4">
    <img src="{{ asset('images/تحقق.jpg') }}" alt="Handshake" class="h-20 w-auto">
</div>
            <h3 class="text-xl font-bold text-[#0D1B2A] mb-2">تحقق فوري</h3>
            <p class="text-gray-600 text-sm leading-relaxed">
                نتائج سريعة وواضحة خلال ثوانٍ فقط.
            </p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition p-8 text-center">
            <div class="flex justify-center mb-4">
    <img src="{{ asset('images/امان.jpg') }}" alt="Handshake" class="h-20 w-auto">
</div>
            <h3 class="text-xl font-bold text-[#0D1B2A] mb-2">أمان وخصوصية</h3>
            <p class="text-gray-600 text-sm leading-relaxed">
                البيانات مشفرة ومحمية من الوصول غير المصرّح به.
            </p>
        </div>

    </div>
</div>

@endsection
