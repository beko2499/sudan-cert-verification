{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'إضافة مدير جديد')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">إضافة مدير جديد</h1>
        </div>
        <p class="text-gray-600">قم بتعبئة البيانات التالية لإضافة مدير جامعة أو مسؤول نظام</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- الاسم -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        الاسم الكامل <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="أدخل الاسم الكامل"
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- البريد الإلكتروني -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        البريد الإلكتروني <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                           placeholder="example@university.edu.sd"
                           required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- كلمة المرور -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        كلمة المرور <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                           placeholder="أدخل كلمة مرور قوية (8 أحرف على الأقل)"
                           required>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- تأكيد كلمة المرور -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        تأكيد كلمة المرور <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="أعد إدخال كلمة المرور"
                           required>
                </div>

                <!-- نوع الحساب -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        نوع الحساب <span class="text-red-500">*</span>
                    </label>
                    <select id="role" 
                            name="role" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror"
                            onchange="toggleUniversityField()"
                            required>
                        <option value="">-- اختر نوع الحساب --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مسؤول النظام (Admin)</option>
                        <option value="university_admin" {{ old('role') == 'university_admin' ? 'selected' : '' }}>مدير جامعة</option>
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">
                        <strong>مسؤول النظام:</strong> صلاحيات كاملة على جميع الجامعات والمستخدمين<br>
                        <strong>مدير جامعة:</strong> صلاحيات إدارة الشهادات والطلاب لجامعة معينة
                    </p>
                </div>

                <!-- اختيار الجامعة (يظهر فقط لمدير الجامعة) -->
                <div id="universityField" class="hidden">
                    <label for="university_id" class="block text-sm font-medium text-gray-700 mb-2">
                        الجامعة <span class="text-red-500">*</span>
                    </label>
                    <select id="university_id" 
                            name="university_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('university_id') border-red-500 @enderror">
                        <option value="">-- اختر الجامعة --</option>
                        @foreach($universities as $university)
                            <option value="{{ $university->id }}" {{ old('university_id') == $university->id ? 'selected' : '' }}>
                                {{ $university->name_ar }}
                            </option>
                        @endforeach
                    </select>
                    @error('university_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حالة التفعيل -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="is_active" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_active" class="mr-3 text-sm font-medium text-gray-700">
                        تفعيل الحساب
                    </label>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    إلغاء
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
                    إنشاء الحساب
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// إظهار/إخفاء حقل الجامعة حسب نوع الحساب
function toggleUniversityField() {
    const role = document.getElementById('role').value;
    const universityField = document.getElementById('universityField');
    const universitySelect = document.getElementById('university_id');
    
    if (role === 'university_admin') {
        universityField.classList.remove('hidden');
        universitySelect.setAttribute('required', 'required');
    } else {
        universityField.classList.add('hidden');
        universitySelect.removeAttribute('required');
        universitySelect.value = '';
    }
}

// تشغيل الدالة عند تحميل الصفحة إذا كان هناك قيمة قديمة
document.addEventListener('DOMContentLoaded', function() {
    toggleUniversityField();
});
</script>
@endsection