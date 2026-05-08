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
            <div class="text-4xl"><svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg></div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">إجمالي الشهادات</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $stats['total_certificates'] }}</h3>
            </div>
            <div class="text-4xl"><svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">معتمدة</p>
                <h3 class="text-3xl font-bold text-emerald-600 mt-1">{{ $stats['verified_certificates'] }}</h3>
            </div>
            <div class="text-4xl"><svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">عمليات التحقق</p>
                <h3 class="text-3xl font-bold text-purple-600 mt-1">{{ $stats['total_verifications'] }}</h3>
            </div>
            <div class="text-4xl"><svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">هذا الشهر</p>
                <h3 class="text-3xl font-bold text-orange-600 mt-1">{{ $stats['verifications_this_month'] }}</h3>
            </div>
            <div class="text-4xl"><svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg></div>
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
