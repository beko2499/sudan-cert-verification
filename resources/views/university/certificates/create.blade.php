{{-- resources/views/university/certificates/create.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'إضافة شهادة جديدة')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">إضافة شهادة جديدة</h1>
        <p class="text-gray-600 mt-2">قم بإدخال معلومات الشهادة بدقة</p>
    </div>

    <form action="{{ route('university.certificates.store') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="card">
        @csrf
        
        <!-- معلومات الطالب -->
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">معلومات الطالب</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">الاسم بالعربية *</label>
                    <input type="text" 
                           name="student_name_ar" 
                           class="input-field @error('student_name_ar') border-red-500 @enderror"
                           value="{{ old('student_name_ar') }}"
                           required>
                    @error('student_name_ar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">الاسم بالإنجليزية</label>
                    <input type="text" 
                           name="student_name_en" 
                           class="input-field"
                           value="{{ old('student_name_en') }}">
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">الرقم الجامعي *</label>
                    <input type="text" 
                           name="student_id" 
                           class="input-field @error('student_id') border-red-500 @enderror"
                           value="{{ old('student_id') }}"
                           required>
                    @error('student_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- معلومات البرنامج الدراسي -->
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">معلومات البرنامج الدراسي</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">الكلية *</label>
                    <input type="text" 
                           name="faculty_ar" 
                           class="input-field @error('faculty_ar') border-red-500 @enderror"
                           value="{{ old('faculty_ar') }}"
                           placeholder="مثال: كلية الهندسة"
                           required>
                    @error('faculty_ar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">البرنامج الدراسي *</label>
                    <input type="text" 
                           name="program_ar" 
                           class="input-field @error('program_ar') border-red-500 @enderror"
                           value="{{ old('program_ar') }}"
                           placeholder="مثال: بكالوريوس الهندسة المدنية"
                           required>
                    @error('program_ar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- معلومات التخرج -->
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">معلومات التخرج</h2>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">سنة التخرج *</label>
                    <input type="number" 
                           name="graduation_year" 
                           class="input-field @error('graduation_year') border-red-500 @enderror"
                           value="{{ old('graduation_year', date('Y')) }}"
                           min="1900"
                           max="{{ date('Y') + 1 }}"
                           required>
                    @error('graduation_year')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">التقدير *</label>
                    <select name="grade" 
                            class="input-field @error('grade') border-red-500 @enderror"
                            required>
                        <option value="">اختر التقدير</option>
                        <option value="ممتاز" {{ old('grade') === 'ممتاز' ? 'selected' : '' }}>ممتاز</option>
                        <option value="جيد جداً" {{ old('grade') === 'جيد جداً' ? 'selected' : '' }}>جيد جداً</option>
                        <option value="جيد" {{ old('grade') === 'جيد' ? 'selected' : '' }}>جيد</option>
                        <option value="مقبول" {{ old('grade') === 'مقبول' ? 'selected' : '' }}>مقبول</option>
                    </select>
                    @error('grade')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">المعدل التراكمي (GPA)</label>
                    <input type="number" 
                           name="gpa" 
                           class="input-field"
                           value="{{ old('gpa') }}"
                           step="0.01"
                           min="0"
                           max="4"
                           placeholder="3.50">
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">تاريخ الإصدار *</label>
                    <input type="date" 
                           name="issue_date" 
                           class="input-field @error('issue_date') border-red-500 @enderror"
                           value="{{ old('issue_date', date('Y-m-d')) }}"
                           required>
                    @error('issue_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- المرفقات والملاحظات -->
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">المرفقات والملاحظات</h2>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">رفع نسخة PDF من الشهادة</label>
                    <input type="file" 
                           name="pdf_file" 
                           class="input-field"
                           accept=".pdf">
                    <p class="text-sm text-gray-500 mt-1">الحد الأقصى: 5 ميجابايت</p>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">ملاحظات إضافية</label>
                    <textarea name="notes" 
                              class="input-field" 
                              rows="4"
                              placeholder="أي ملاحظات أو تفاصيل إضافية...">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>
        
        <!-- أزرار الإجراءات -->
        <div class="flex gap-4 justify-end pt-6 border-t">
            <a href="{{ route('university.dashboard') }}" 
               class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                إلغاء
            </a>
            <button type="submit" class="btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg> حفظ الشهادة
            </button>
        </div>
    </form>
</div>
@endsection