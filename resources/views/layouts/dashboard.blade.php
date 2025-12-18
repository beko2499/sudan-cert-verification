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
                        📊 الرئيسية
                    </a>
                    
                    <div class="px-4 py-2 mt-4">
                        <p class="text-xs text-primary-300 uppercase tracking-wider">إدارة الجامعات</p>
                    </div>
                    
                    <a href="{{ route('admin.universities.create') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('admin.universities.create') ? 'bg-primary-800' : '' }}">
                        ➕ إضافة جامعة
                    </a>
                    <a href="{{ route('admin.users.create') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('admin.users.create') ? 'bg-primary-800' : '' }}">
                        👤 إضافة مدير
                    </a>
                    
                    <div class="px-4 py-2 mt-4">
                        <p class="text-xs text-primary-300 uppercase tracking-wider">التقارير</p>
                    </div>
                    
                    <a href="{{ route('admin.statistics') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('admin.statistics') ? 'bg-primary-800' : '' }}">
                        📈 الإحصائيات
                    </a>
                    <a href="{{ route('admin.suspicious') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('admin.suspicious') ? 'bg-primary-800' : '' }}">
                        ⚠️ الأنشطة المشبوهة
                    </a>
                    <a href="{{ route('admin.logs') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('admin.logs') ? 'bg-primary-800' : '' }}">
                        🔍 سجل التحقق
                    </a>
                @endif
                
                @if(auth()->user()->university_id)
                    <a href="{{ route('university.dashboard') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('university.dashboard') ? 'bg-primary-800' : '' }}">
                        📊 الرئيسية
                    </a>
                    
                    <div class="px-4 py-2 mt-4">
                        <p class="text-xs text-primary-300 uppercase tracking-wider">إدارة الشهادات</p>
                    </div>
                    
                    <a href="{{ route('university.certificates.index') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('university.certificates.index') ? 'bg-primary-800' : '' }}">
                        📋 جميع الشهادات
                    </a>
                    <a href="{{ route('university.certificates.create') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('university.certificates.create') ? 'bg-primary-800' : '' }}">
                        ➕ إضافة شهادة
                    </a>
                    <a href="{{ route('university.export') }}" 
                       class="block px-6 py-3 hover:bg-primary-800">
                        📥 تصدير البيانات
                    </a>
                    
                    <div class="px-4 py-2 mt-4">
                        <p class="text-xs text-primary-300 uppercase tracking-wider">السجلات</p>
                    </div>
                    
                    <a href="{{ route('university.logs') }}" 
                       class="block px-6 py-3 hover:bg-primary-800 {{ request()->routeIs('university.logs') ? 'bg-primary-800' : '' }}">
                        🔍 سجلات التحقق
                    </a>
                @endif
                
                <form method="POST" action="{{ route('logout') }}" class="mt-8">
                    @csrf
                    <button type="submit" class="block w-full text-right px-6 py-3 hover:bg-primary-800">
                        🚪 تسجيل الخروج
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