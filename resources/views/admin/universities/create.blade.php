@extends('layouts.dashboard')

@section('title', 'إضافة جامعة جديدة')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">إضافة جامعة جديدة</h1>
        </div>
        <p class="text-gray-600">قم بتعبئة البيانات التالية لإضافة جامعة جديدة للنظام</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <form action="{{ route('admin.universities.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                {{-- بيانات الجامعة --}}
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">الاسم بالعربية *</label>
                        <input type="text" name="name_ar" value="{{ old('name_ar') }}" required
                               class="w-full px-4 py-3 border rounded-lg @error('name_ar') border-red-500 @enderror">
                        @error('name_ar')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">الاسم بالإنجليزية *</label>
                        <input type="text" name="name_en" value="{{ old('name_en') }}" required
                               class="w-full px-4 py-3 border rounded-lg @error('name_en') border-red-500 @enderror">
                        @error('name_en')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">كود الجامعة *</label>
                        <input type="text" name="code" value="{{ old('code') }}" maxlength="10" required
                               class="w-full px-4 py-3 border rounded-lg @error('code') border-red-500 @enderror">
                        @error('code')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">البريد الإلكتروني (للجامعة)</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full px-4 py-3 border rounded-lg @error('email') border-red-500 @enderror">
                        @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">رقم الهاتف</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="w-full px-4 py-3 border rounded-lg @error('phone') border-red-500 @enderror">
                        @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">العنوان</label>
                    <textarea name="address" rows="3"
                              class="w-full px-4 py-3 border rounded-lg @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                    @error('address')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">شعار الجامعة</label>
                    <input type="file" name="logo" accept="image/png,image/jpeg"
                           class="w-full px-4 py-3 border rounded-lg @error('logo') border-red-500 @enderror">
                    @error('logo')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" id="is_active"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-gray-300 rounded">
                    <label for="is_active" class="mr-3 text-sm">تفعيل الجامعة</label>
                </div>

                {{-- بيانات مدير الجامعة --}}
                <div class="border-t pt-6">
                    <h2 class="text-lg font-bold mb-4">بيانات مدير الجامعة</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium mb-2">الاسم *</label>
                            <input type="text" name="manager_name" value="{{ old('manager_name') }}" required
                                   class="w-full px-4 py-3 border rounded-lg @error('manager_name') border-red-500 @enderror">
                            @error('manager_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium mb-2">البريد الإلكتروني *</label>
                            <input type="email" name="manager_email" value="{{ old('manager_email') }}" required
                                   class="w-full px-4 py-3 border rounded-lg @error('manager_email') border-red-500 @enderror">
                            @error('manager_email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium mb-2">كلمة المرور (اختياري)</label>
                            <input type="text" name="manager_password" placeholder="اتركها فارغة = password123"
                                   class="w-full px-4 py-3 border rounded-lg @error('manager_password') border-red-500 @enderror">
                            @error('manager_password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 border border-gray-300 rounded-lg">إلغاء</a>
                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">حفظ الجامعة</button>
            </div>
        </form>
    </div>
</div>
@endsection
