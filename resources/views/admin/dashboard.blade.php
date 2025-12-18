{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'لوحة تحكم الإدارة')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">لوحة تحكم الإدارة المركزية</h1>
    <p class="text-gray-600 mt-2">مرحباً بك في نظام إدارة الشهادات الجامعية</p>
</div>

<!-- الإحصائيات -->
<div class="grid md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">الجامعات</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['total_universities'] }}</h3>
            </div>
            <div class="text-4xl">🏛️</div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">إجمالي الشهادات</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $stats['total_certificates'] }}</h3>
            </div>
            <div class="text-4xl">📜</div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">معتمدة</p>
                <h3 class="text-3xl font-bold text-emerald-600 mt-1">{{ $stats['verified_certificates'] }}</h3>
            </div>
            <div class="text-4xl">✅</div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">عمليات التحقق</p>
                <h3 class="text-3xl font-bold text-purple-600 mt-1">{{ $stats['total_verifications'] }}</h3>
            </div>
            <div class="text-4xl">🔍</div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">هذا الشهر</p>
                <h3 class="text-3xl font-bold text-orange-600 mt-1">{{ $stats['verifications_this_month'] }}</h3>
            </div>
            <div class="text-4xl">📈</div>
        </div>
    </div>
</div>

<!-- الجامعات الأكثر نشاطاً وآخر عمليات التحقق -->
<div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex justify-between items-center mb-4 pb-2 border-b">
            <h2 class="text-lg font-bold text-gray-800">الجامعات الأكثر نشاطاً</h2>
            <span class="text-sm text-gray-500">أعلى 5 جامعات</span>
        </div>
        <div class="space-y-3">
            @forelse($activeUniversities as $uni)
                <a href="{{ route('admin.universities.show', $uni->id) }}" 
                   class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center gap-3">
                        @if($uni->logo)
                            <img src="{{ asset('storage/' . $uni->logo) }}" class="w-10 h-10 rounded-full object-cover border">
                        @else
                            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold">
                                {{ mb_substr($uni->name_ar, 0, 1) }}
                            </div>
                        @endif
                        <span class="font-medium">{{ $uni->name_ar }}</span>
                    </div>
                    <span class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-sm">
                        {{ $uni->certificates_count }} شهادة
                    </span>
                </a>
            @empty
                <p class="text-center text-gray-500 py-4">لا توجد جامعات</p>
            @endforelse
        </div>
    </div>
    
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex justify-between items-center mb-4 pb-2 border-b">
            <h2 class="text-lg font-bold text-gray-800">آخر عمليات التحقق</h2>
            <span class="text-sm text-gray-500">آخر 10 عمليات</span>
        </div>
        <div class="space-y-3">
            @forelse($recentVerifications as $log)
                @if($log->certificate)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium font-mono text-sm">{{ $log->certificate->certificate_number }}</p>
                        <p class="text-xs text-gray-600">{{ $log->certificate->university->name_ar ?? 'جامعة محذوفة' }}</p>
                    </div>
                    <div class="text-left">
                        <span class="text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</span>
                        <p class="text-xs text-gray-400">{{ $log->ip_address ?? '-' }}</p>
                    </div>
                </div>
                @endif
            @empty
                <p class="text-center text-gray-500 py-4">لا توجد عمليات تحقق</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
