<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    <!-- Top Government Bar -->
    <div class="bg-[#0D1B2A] text-white py-2 text-sm text-center tracking-wide">
        وزارة التعليم العالي والبحث العلمي - جمهورية السودان
    </div>

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between flex-wrap gap-4">

                <!-- Logo + Title -->
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/شعارونا.jpg') }}" alt="الشعار" class="h-16 w-auto">
                    <div>
                        <h1 class="text-2xl font-extrabold text-[#0D1B2A]">
                            النظام القومي للتحقق من الشهادات الجامعية
                        </h1>
                        <p class="text-xs text-gray-500">
                            National University Certificate Verification System
                        </p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex gap-6 text-sm font-medium">
                    <a href="{{ route('home') }}" class="hover:text-[#0D1B2A] transition">الرئيسية</a>
                    <a href="{{ route('verify') }}" class="hover:text-[#0D1B2A] transition">التحقق من شهادة</a>
                    <a href="{{ route('contact') }}" class="hover:text-[#0D1B2A] transition">التواصل</a>

                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0D1B2A] transition">لوحة التحكم</a>
                        @elseif(auth()->user()->hasRole('university_admin'))
                            <a href="{{ route('university.dashboard') }}" class="hover:text-[#0D1B2A] transition">لوحة التحكم</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-[#0D1B2A] border border-[#0D1B2A] px-4 py-1 rounded hover:bg-[#0D1B2A] hover:text-white transition">
                            تسجيل الدخول
                        </a>
                    @endauth
                </nav>

            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-10 flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#0D1B2A] text-white mt-10">
        <div class="container mx-auto px-4 py-10 grid md:grid-cols-3 gap-8">

            <div>
                <h3 class="text-lg font-bold mb-3">عن النظام</h3>
                <p class="text-sm text-gray-300 leading-relaxed">
                    منصة حكومية رسمية تسهّل التحقق من صحة الشهادات الجامعية للحد من التزوير والاحتيال.
                </p>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-3">روابط مهمة</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-300 hover:text-white transition">وزارة التعليم العالي</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition">سياسة الخصوصية</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition">الأسئلة الشائعة</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-3">تواصل معنا</h3>
                <p class="text-sm text-gray-300 leading-relaxed">
                    البريد: info@mohe.gov.sd <br>
                    الهاتف: +249 123 456 789
                </p>
            </div>

        </div>

        <div class="bg-[#0A1623] text-center py-4 text-xs text-gray-400">
            © {{ date('Y') }} وزارة التعليم العالي والبحث العلمي - جميع الحقوق محفوظة
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
