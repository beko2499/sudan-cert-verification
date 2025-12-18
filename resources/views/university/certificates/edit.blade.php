{{-- resources/views/university/certificates/edit.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'تعديل الشهادة')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">تعديل بيانات الشهادة</h1>
        <p class="text-gray-600 mt-2">رقم الشهادة: <span class="font-semibold text-primary-700">{{ $certificate->certificate_number }}</span></p>
    </div>

    <form action="{{ route('university.certificates.update', $certificate) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="card">
        @csrf
        @method('PUT')
        
        <!-- معلومات الطالب -->
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">معلومات الطالب</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">الاسم بالعربية *</label>
                    <input type="text" 
                           name="student_name_ar" 
                           class="input-field @error('student_name_ar') border-red-500 @enderror"
                           value="{{ old('student_name_ar', $certificate->student_name_ar) }}"
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
                           value="{{ old('student_name_en', $certificate->student_name_en) }}">
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">الرقم الجامعي *</label>
                    <input type="text" 
                           name="student_id" 
                           class="input-field @error('student_id') border-red-500 @enderror"
                           value="{{ old('student_id', $certificate->student_id) }}"
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
                           value="{{ old('faculty_ar', $certificate->faculty_ar) }}"
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
                           value="{{ old('program_ar', $certificate->program_ar) }}"
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
                           value="{{ old('graduation_year', $certificate->graduation_year) }}"
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
                        <option value="ممتاز" {{ old('grade', $certificate->grade) === 'ممتاز' ? 'selected' : '' }}>ممتاز</option>
                        <option value="جيد جداً" {{ old('grade', $certificate->grade) === 'جيد جداً' ? 'selected' : '' }}>جيد جداً</option>
                        <option value="جيد" {{ old('grade', $certificate->grade) === 'جيد' ? 'selected' : '' }}>جيد</option>
                        <option value="مقبول" {{ old('grade', $certificate->grade) === 'مقبول' ? 'selected' : '' }}>مقبول</option>
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
                           value="{{ old('gpa', $certificate->gpa) }}"
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
                           value="{{ old('issue_date', $certificate->issue_date ? \Carbon\Carbon::parse($certificate->issue_date)->format('Y-m-d') : '') }}"
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
                    @if($certificate->pdf_file)
                        <div class="mb-2 p-3 bg-gray-100 rounded-lg flex items-center justify-between">
                            <span class="text-sm text-gray-600">📄 يوجد ملف PDF مرفق حالياً</span>
                            <a href="{{ asset('storage/' . $certificate->pdf_file) }}" 
                               target="_blank"
                               class="text-primary-600 hover:text-primary-800 text-sm">
                                عرض الملف
                            </a>
                        </div>
                    @endif
                    <input type="file" 
                           name="pdf_file" 
                           class="input-field"
                           accept=".pdf">
                    <p class="text-sm text-gray-500 mt-1">الحد الأقصى: 5 ميجابايت (اترك فارغاً للاحتفاظ بالملف الحالي)</p>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">ملاحظات إضافية</label>
                    <textarea name="notes" 
                              class="input-field" 
                              rows="4"
                              placeholder="أي ملاحظات أو تفاصيل إضافية...">{{ old('notes', $certificate->notes) }}</textarea>
                </div>
            </div>
        </div>

        <!-- حالة الشهادة -->
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">حالة الشهادة</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">الحالة</label>
                    <select name="status" class="input-field">
                        <option value="pending" {{ old('status', $certificate->status) === 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                        <option value="verified" {{ old('status', $certificate->status) === 'verified' ? 'selected' : '' }}>معتمدة</option>
                        <option value="suspended" {{ old('status', $certificate->status) === 'suspended' ? 'selected' : '' }}>موقوفة</option>
                    </select>
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
                💾 حفظ التعديلات
            </button>
        </div>
    </form>

    <!-- نموذج الحذف منفصل -->
    <div class="mt-8 pt-6 border-t border-red-200">
        <div class="bg-red-50 rounded-lg p-4">
            <h3 class="text-lg font-bold text-red-800 mb-2">منطقة الخطر</h3>
            <p class="text-red-600 text-sm mb-4">حذف الشهادة سيؤدي إلى إزالتها نهائياً من النظام ولا يمكن التراجع عن هذا الإجراء.</p>
            <form action="{{ route('university.certificates.destroy', $certificate) }}" 
                  method="POST" 
                  onsubmit="return confirm('هل أنت متأكد من حذف هذه الشهادة؟ لا يمكن التراجع عن هذا الإجراء.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    🗑️ حذف الشهادة
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

