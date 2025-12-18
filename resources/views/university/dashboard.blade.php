{{-- resources/views/university/dashboard.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'لوحة التحكم')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">مرحباً، {{ auth()->user()->university->name_ar }}</h1>
    <p class="text-gray-600 mt-2">إليك ملخص نشاط الشهادات</p>
</div>

<!-- الإحصائيات -->
<div class="grid md:grid-cols-5 gap-6 mb-8">
    <div class="card bg-gradient-to-br from-blue-500 to-blue-600 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm">إجمالي الشهادات</p>
                <h3 class="text-3xl font-bold mt-2">{{ $stats['total'] }}</h3>
            </div>
            <div class="text-5xl opacity-50">📜</div>
        </div>
    </div>
    
    <div class="card bg-gradient-to-br from-green-500 to-green-600 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm">معتمدة</p>
                <h3 class="text-3xl font-bold mt-2">{{ $stats['verified'] }}</h3>
            </div>
            <div class="text-5xl opacity-50">✅</div>
        </div>
    </div>
    
    <div class="card bg-gradient-to-br from-yellow-500 to-yellow-600 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm">قيد المراجعة</p>
                <h3 class="text-3xl font-bold mt-2">{{ $stats['pending'] }}</h3>
            </div>
            <div class="text-5xl opacity-50">⏳</div>
        </div>
    </div>
    
    <div class="card bg-gradient-to-br from-orange-500 to-orange-600 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm">موقوفة</p>
                <h3 class="text-3xl font-bold mt-2">{{ $stats['suspended'] }}</h3>
            </div>
            <div class="text-5xl opacity-50">⚠️</div>
        </div>
    </div>
    
    <div class="card bg-gradient-to-br from-purple-500 to-purple-600 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm">عمليات التحقق (هذا الشهر)</p>
                <h3 class="text-3xl font-bold mt-2">{{ $stats['verifications'] }}</h3>
            </div>
            <div class="text-5xl opacity-50">🔍</div>
        </div>
    </div>
</div>

<!-- آخر الشهادات المضافة -->
<div class="card">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">آخر الشهادات المضافة</h2>
        <a href="{{ route('university.certificates.index') }}" class="text-primary-600 hover:text-primary-800 text-sm">
            عرض الكل ←
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">رقم الشهادة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">اسم الطالب</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">البرنامج</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">سنة التخرج</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الحالة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentCertificates as $cert)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm">{{ $cert->certificate_number }}</td>
                    <td class="px-4 py-3 text-sm font-medium">{{ $cert->student_name_ar }}</td>
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
                               class="text-primary-600 hover:text-primary-800">عرض</a>
                            <a href="{{ route('university.certificates.edit', $cert) }}" 
                               class="text-blue-600 hover:text-blue-800">تعديل</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        لا توجد شهادات حتى الآن
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection