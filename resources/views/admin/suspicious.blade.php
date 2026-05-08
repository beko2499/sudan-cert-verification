{{-- resources/views/admin/suspicious.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'الأنشطة المشبوهة')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">الأنشطة المشبوهة</h1>
    <p class="text-gray-600 mt-2">مراقبة الأنشطة غير الطبيعية في النظام</p>
</div>

<!-- الشهادات التي تم التحقق منها كثيراً -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-8">
    <div class="flex items-center gap-2 mb-4 pb-2 border-b">
        <span class="text-2xl"><svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></span>
        <h2 class="text-lg font-bold text-gray-800">شهادات بتحقق مكثف اليوم</h2>
        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">أكثر من 10 مرات</span>
    </div>
    
    @if($suspiciousCerts->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">رقم الشهادة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الجامعة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">عدد التحققات اليوم</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($suspiciousCerts as $cert)
                <tr class="hover:bg-red-50">
                    <td class="px-4 py-3 text-sm font-mono">{{ $cert->certificate_number }}</td>
                    <td class="px-4 py-3 text-sm">{{ $cert->university->name_ar ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-bold">
                            {{ $cert->today_verifications }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-center text-gray-500 py-8"><svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> لا توجد شهادات مشبوهة اليوم</p>
    @endif
</div>

<!-- شهادات قيد المراجعة لفترة طويلة -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
    <div class="flex items-center gap-2 mb-4 pb-2 border-b">
        <span class="text-2xl">⏰</span>
        <h2 class="text-lg font-bold text-gray-800">شهادات معلقة لأكثر من 7 أيام</h2>
        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">تحتاج مراجعة</span>
    </div>
    
    @if($pendingCerts->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">رقم الشهادة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">اسم الطالب</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الجامعة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">تاريخ الإضافة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الأيام المنقضية</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($pendingCerts as $cert)
                <tr class="hover:bg-yellow-50">
                    <td class="px-4 py-3 text-sm font-mono">{{ $cert->certificate_number }}</td>
                    <td class="px-4 py-3 text-sm">{{ $cert->student_name_ar }}</td>
                    <td class="px-4 py-3 text-sm">{{ $cert->university->name_ar ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $cert->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-bold">
                            {{ $cert->created_at->diffInDays(now()) }} يوم
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-center text-gray-500 py-8"><svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 ml-1 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> لا توجد شهادات معلقة لفترة طويلة</p>
    @endif
</div>
@endsection
