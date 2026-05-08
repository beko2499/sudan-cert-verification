{{-- resources/views/layouts/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - لوحة التحكم</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-primary-900 text-white">
            <div class="p-6">
                <h2 class="text-xl font-bold">لوحة التحكم</h2>
                <p class="text-sm text-primary-200">{{ auth()->user()->name }}</p>
            </div>
            
            <nav class="mt-6">
                @if(!auth()->user()->university_id && request()->is('admin/*'))
                    <a href="{{ route('admin.dashboard') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-800' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg> الرئيسية
                    </a>
                    
                    <div class="px-4 py-2 mt-4">
                        <p class="text-xs text-primary-300 uppercase tracking-wider">إدارة الجامعات</p>
                    </div>
                    
                    <a href="{{ route('admin.universities.create') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('admin.universities.create') ? 'bg-primary-800' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> إضافة جامعة
                    </a>
                    <a href="{{ route('admin.users.create') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('admin.users.create') ? 'bg-primary-800' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg> إضافة مدير
                    </a>
                    
                    <div class="px-4 py-2 mt-4">
                        <p class="text-xs text-primary-300 uppercase tracking-wider">التقارير</p>
                    </div>
                    
                    <a href="{{ route('admin.statistics') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('admin.statistics') ? 'bg-primary-800' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg> الإحصائيات
                    </a>
                    <a href="{{ route('admin.suspicious') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('admin.suspicious') ? 'bg-primary-800' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> الأنشطة المشبوهة
                    </a>
                    <a href="{{ route('admin.logs') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('admin.logs') ? 'bg-primary-800' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> سجل التحقق
                    </a>
                @endif
                
                @if(auth()->user()->university_id)
                    <a href="{{ route('university.dashboard') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('university.dashboard') ? 'bg-primary-800' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg> الرئيسية
                    </a>
                    
                    <div class="px-4 py-2 mt-4">
                        <p class="text-xs text-primary-300 uppercase tracking-wider">إدارة الشهادات</p>
                    </div>
                    
                    <a href="{{ route('university.certificates.index') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('university.certificates.index') ? 'bg-primary-800' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg> جميع الشهادات
                    </a>
                    <a href="{{ route('university.certificates.create') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('university.certificates.create') ? 'bg-primary-800' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> إضافة شهادة
                    </a>
                    <a href="{{ route('university.export') }}" 
                       class="block px-6 py-3 hover:bg-primary-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> تصدير البيانات
                    </a>
                    
                    <div class="px-4 py-2 mt-4">
                        <p class="text-xs text-primary-300 uppercase tracking-wider">السجلات</p>
                    </div>
                    
                    <a href="{{ route('university.logs') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('university.logs') ? 'bg-primary-800' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> سجلات التحقق
                    </a>
                @endif
                
                <form method="POST" action="{{ route('logout') }}" class="mt-8">
                    @csrf
                    <button type="submit" class="block w-full text-right px-6 py-3 hover:bg-primary-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg> تسجيل الخروج
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="p-8">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>