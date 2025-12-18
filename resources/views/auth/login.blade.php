@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="max-w-md mx-auto">

    <div class="bg-white border border-gray-200 shadow-lg rounded-xl p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">تسجيل الدخول</h1>
            <p class="text-gray-600 text-sm mt-2">يرجى إدخال بيانات الدخول للوصول إلى لوحة التحكم</p>
        </div>
<div class="mb-6 bg-yellow-50 border border-yellow-300 text-yellow-800 p-4 rounded-lg text-sm leading-relaxed">
    <strong class="font-semibold">تنبيه:</strong>
    هذا النظام مخصص فقط للمستخدمين المخولين بالوصول. 
    أي محاولة دخول غير مصرح بها أو استخدام حساب لا يتبع لك قد يعرضك للمساءلة القانونية وفق اللوائح المعمول بها.
</div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-green-700 bg-green-50 border border-green-200 p-3 rounded">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">البريد الإلكتروني</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-600 transition"
                >
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-2">كلمة المرور</label>
                <div class="relative">
                    <input 
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-12 focus:ring-2 focus:ring-primary-600 transition"
                    >
                    <button 
                        type="button" 
                        onclick="togglePassword()"
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                    >
                        <svg id="eye-open" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg id="eye-closed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center gap-2">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-primary-700 shadow-sm focus:ring-primary-600">
                <label for="remember_me" class="text-sm text-gray-700">تذكرني</label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-4">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-primary-700 hover:underline">
                        هل نسيت كلمة المرور؟
                    </a>
                @endif

                <button type="submit" class="bg-primary-700 hover:bg-primary-800 text-white px-6 py-3 rounded-lg font-semibold transition">
                    دخول
                </button>
            </div>
        </form>
    </div>

</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
    } else {
        passwordInput.type = 'password';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    }
}
</script>
@endsection
