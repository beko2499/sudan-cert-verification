{{-- resources/views/university/logs.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'سجلات التحقق')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">سجلات التحقق</h1>
    <p class="text-gray-600 mt-1">عرض جميع عمليات التحقق من الشهادات</p>
</div>

<div class="card">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">#</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">رقم الشهادة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">اسم الطالب</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">مصدر التحقق</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">عنوان IP</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">التاريخ والوقت</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                    <td class="px-4 py-3 text-sm font-mono">
                        <a href="{{ route('university.certificates.show', $log->certificate) }}" 
                           class="text-primary-600 hover:text-primary-800">
                            {{ $log->certificate->certificate_number }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm font-medium">{{ $log->certificate->student_name_ar }}</td>
                    <td class="px-4 py-3">
                        @if($log->verification_source === 'web')
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">نموذج التحقق</span>
                        @elseif($log->verification_source === 'direct_link')
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">رابط مباشر</span>
                        @elseif($log->verification_source === 'qr_code')
                            <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">QR Code</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">{{ $log->verification_source }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-500 font-mono">{{ $log->ip_address }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        لا توجد سجلات تحقق حتى الآن
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- الترقيم -->
    @if($logs->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $logs->links() }}
    </div>
    @endif
</div>

<!-- إحصائيات سريعة -->
<div class="mt-6 grid md:grid-cols-3 gap-4">
    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
        <p class="text-sm text-blue-600">إجمالي عمليات التحقق</p>
        <p class="text-2xl font-bold text-blue-800">{{ $logs->total() }}</p>
    </div>
    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
        <p class="text-sm text-green-600">عمليات اليوم</p>
        <p class="text-2xl font-bold text-green-800">{{ $logs->where('created_at', '>=', now()->startOfDay())->count() }}</p>
    </div>
    <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
        <p class="text-sm text-purple-600">هذا الأسبوع</p>
        <p class="text-2xl font-bold text-purple-800">{{ $logs->where('created_at', '>=', now()->startOfWeek())->count() }}</p>
    </div>
</div>
@endsection
