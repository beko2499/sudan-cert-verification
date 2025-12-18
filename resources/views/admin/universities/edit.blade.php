@extends('layouts.dashboard')

@section('title', 'تعديل بيانات الجامعة')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <h1 class="text-3xl font-bold text-gray-800 mb-6">تعديل بيانات الجامعة</h1>

    <div class="bg-white shadow rounded-lg p-8">

        <form action="{{ route('admin.universities.update', $university->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">

                <div>
                    <label class="block text-sm font-medium mb-2">الاسم بالعربية</label>
                    <input type="text" name="name_ar" value="{{ old('name_ar', $university->name_ar) }}"
                        class="w-full px-4 py-3 border rounded-lg" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">الاسم بالإنجليزية</label>
                    <input type="text" name="name_en" value="{{ old('name_en', $university->name_en) }}"
                        class="w-full px-4 py-3 border rounded-lg" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">كود الجامعة</label>
                    <input type="text" name="code" value="{{ old('code', $university->code) }}"
                        class="w-full px-4 py-3 border rounded-lg" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email', $university->email) }}"
                        class="w-full px-4 py-3 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone', $university->phone) }}"
                        class="w-full px-4 py-3 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">العنوان</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-3 border rounded-lg">{{ old('address', $university->address) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">شعار الجامعة</label>
                    <input type="file" name="logo" class="w-full px-4 py-3 border rounded-lg">

                    @if($university->logo)
                        <img src="{{ asset('storage/'.$university->logo) }}" class="w-24 h-24 mt-3 border rounded">
                    @endif
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ $university->is_active ? 'checked' : '' }} class="w-5 h-5">
                    <label class="mr-3 text-sm font-medium">تفعيل الجامعة</label>
                </div>

            </div>

            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-gray-200 rounded-lg hover:bg-gray-300">رجوع</a>
                <button class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">حفظ التعديلات</button>
            </div>

        </form>

    </div>

</div>
@endsection
