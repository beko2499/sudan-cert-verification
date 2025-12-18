{{-- resources/views/admin/statistics.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'الإحصائيات')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">الإحصائيات التفصيلية</h1>
    <p class="text-gray-600 mt-2">عرض إحصائيات الشهادات وعمليات التحقق</p>
</div>

<!-- إحصائيات شهرية -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-8">
    <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">الإحصائيات الشهرية (آخر 12 شهر)</h2>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الشهر</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الشهادات المضافة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">عمليات التحقق</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($monthlyStats as $stat)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-medium">{{ $stat['month_name'] }}</td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                            {{ $stat['certificates'] }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            {{ $stat['verifications'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- إحصائيات الجامعات -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
    <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">إحصائيات الجامعات</h2>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الجامعة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">إجمالي الشهادات</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">معتمدة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">نسبة الاعتماد</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($universityStats as $uni)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.universities.show', $uni) }}" class="font-medium text-primary-600 hover:underline">
                            {{ $uni->name_ar }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $uni->certificates_count }}</td>
                    <td class="px-4 py-3 text-sm">{{ $uni->verified_count }}</td>
                    <td class="px-4 py-3">
                        @if($uni->certificates_count > 0)
                            @php $percentage = round(($uni->verified_count / $uni->certificates_count) * 100); @endphp
                            <div class="flex items-center gap-2">
                                <div class="w-20 bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600">{{ $percentage }}%</span>
                            </div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">لا توجد جامعات</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
