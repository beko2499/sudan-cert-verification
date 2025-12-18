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
        <span class="text-2xl">🚨</span>
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
    <p class="text-center text-gray-500 py-8">✅ لا توجد شهادات مشبوهة اليوم</p>
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
    <p class="text-center text-gray-500 py-8">✅ لا توجد شهادات معلقة لفترة طويلة</p>
    @endif
</div>
@endsection
