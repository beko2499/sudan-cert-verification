{{-- resources/views/admin/logs.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'سجل التحقق')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">سجل عمليات التحقق</h1>
    <p class="text-gray-600 mt-2">جميع عمليات التحقق من الشهادات في النظام</p>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">#</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">رقم الشهادة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">الجامعة</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">مصدر التحقق</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">عنوان IP</th>
                    <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">التاريخ والوقت</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($logs as $log)
                    @if($log->certificate)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                        <td class="px-4 py-3 text-sm font-mono">
                            <a href="{{ route('certificate.show', $log->certificate->certificate_number) }}" 
                               target="_blank"
                               class="text-primary-600 hover:underline">
                                {{ $log->certificate->certificate_number }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $log->certificate->university->name_ar ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($log->verification_source === 'web')
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">نموذج التحقق</span>
                            @elseif($log->verification_source === 'direct_link')
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">رابط مباشر</span>
                            @elseif($log->verification_source === 'qr_code')
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">QR Code</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">{{ $log->verification_source ?? '-' }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500 font-mono">{{ $log->ip_address ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                    @endif
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                        لا توجد سجلات تحقق
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
@endsection
