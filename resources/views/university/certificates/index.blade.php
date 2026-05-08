{{-- resources/views/university/certificates/index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'جميع الشهادات')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">إدارة الشهادات</h1>
    <p class="text-gray-600 mt-1">عرض وإدارة جميع الشهادات المسجلة</p>
</div>

<!-- الإحصائيات المصغرة -->
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-blue-50 rounded-lg p-4 text-center border border-blue-200">
        <p class="text-2xl font-bold text-blue-700">{{ $stats['total'] }}</p>
        <p class="text-sm text-blue-600">الإجمالي</p>
    </div>
    <div class="bg-green-50 rounded-lg p-4 text-center border border-green-200">
        <p class="text-2xl font-bold text-green-700">{{ $stats['verified'] }}</p>
        <p class="text-sm text-green-600">معتمدة</p>
    </div>
    <div class="bg-yellow-50 rounded-lg p-4 text-center border border-yellow-200">
        <p class="text-2xl font-bold text-yellow-700">{{ $stats['pending'] }}</p>
        <p class="text-sm text-yellow-600">قيد المراجعة</p>
    </div>
    <div class="bg-orange-50 rounded-lg p-4 text-center border border-orange-200">
        <p class="text-2xl font-bold text-orange-700">{{ $stats['suspended'] }}</p>
        <p class="text-sm text-orange-600">موقوفة</p>
    </div>
</div>

<!-- البحث والفلترة -->
<div class="card mb-6">
    <form method="GET" action="{{ route('university.certificates.index') }}" class="flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">بحث</label>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="رقم الشهادة، اسم الطالب، الرقم الجامعي..."
                   class="input-field">
        </div>
        <div class="w-48">
            <label class="block text-sm font-medium text-gray-700 mb-1">الحالة</label>
            <select name="status" class="input-field">
                <option value="">جميع الحالات</option>
                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>معتمدة</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>موقوفة</option>
            </select>
        </div>
        <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> بحث
        </button>
        @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('university.certificates.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                مسح الفلاتر
            </a>
        @endif
    </form>
</div>

<!-- جدول الشهادات -->
<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">رقم الشهادة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">اسم الطالب</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الرقم الجامعي</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">البرنامج</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">سنة التخرج</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الحالة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($certificates as $cert)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-mono">{{ $cert->certificate_number }}</td>
                    <td class="px-4 py-3 text-sm font-medium">{{ $cert->student_name_ar }}</td>
                    <td class="px-4 py-3 text-sm">{{ $cert->student_id }}</td>
                    <td class="px-4 py-3 text-sm">{{ $cert->program_ar }}</td>
                    <td class="px-4 py-3 text-sm">{{ $cert->graduation_year }}</td>
                    <td class="px-4 py-3">
                        @if($cert->status === 'verified')
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">معتمدة</span>
                        @elseif($cert->status === 'pending')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">قيد المراجعة</span>
                        @elseif($cert->status === 'suspended')
                            <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full">موقوفة</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('university.certificates.show', $cert) }}" 
                               class="text-primary-600 hover:text-primary-800 text-sm">عرض</a>
                            <a href="{{ route('university.certificates.edit', $cert) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">تعديل</a>
                            <a href="{{ route('certificate.show', $cert->certificate_number) }}" 
                               class="text-green-600 hover:text-green-800 text-sm" 
                               target="_blank">التحقق</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                        @if(request()->hasAny(['search', 'status']))
                            لا توجد نتائج مطابقة للبحث
                        @else
                            لا توجد شهادات حتى الآن
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- الترقيم -->
    @if($certificates->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $certificates->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
