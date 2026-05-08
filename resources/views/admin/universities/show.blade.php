{{-- resources/views/admin/universities/show.blade.php --}}
@extends('layouts.dashboard')

@section('title', $university->name_ar)

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- رأس الصفحة -->
    <div class="flex justify-between items-start mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-3xl font-bold text-gray-800">{{ $university->name_ar }}</h1>
                @if($university->is_active)
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">نشطة</span>
                @else
                    <span class="px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">معطلة</span>
                @endif
            </div>
            @if($university->name_en)
                <p class="text-gray-500 text-lg">{{ $university->name_en }}</p>
            @endif
            <p class="text-gray-400 mt-1">كود الجامعة: <span class="font-mono font-bold text-primary-600">{{ $university->code }}</span></p>
        </div>
        
        <div class="flex gap-3">
            <a href="{{ route('admin.universities.edit', $university) }}" 
               class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> تعديل
            </a>
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                ← العودة
            </a>
        </div>
    </div>

    <!-- الإحصائيات -->
    <div class="grid md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-5 shadow-lg">
            <p class="text-blue-100 text-sm">إجمالي الشهادات</p>
            <p class="text-3xl font-bold mt-1">{{ $stats['total_certificates'] }}</p>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-5 shadow-lg">
            <p class="text-green-100 text-sm">معتمدة</p>
            <p class="text-3xl font-bold mt-1">{{ $stats['verified'] }}</p>
        </div>
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-xl p-5 shadow-lg">
            <p class="text-yellow-100 text-sm">قيد المراجعة</p>
            <p class="text-3xl font-bold mt-1">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl p-5 shadow-lg">
            <p class="text-orange-100 text-sm">موقوفة</p>
            <p class="text-3xl font-bold mt-1">{{ $stats['suspended'] ?? 0 }}</p>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- معلومات الجامعة -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">معلومات الجامعة</h2>
                
                <div class="space-y-4">
                    @if($university->logo)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $university->logo) }}" 
                             alt="{{ $university->name_ar }}" 
                             class="w-24 h-24 mx-auto object-contain rounded-lg border">
                    </div>
                    @endif
                    
                    <div>
                        <p class="text-gray-500 text-sm">البريد الإلكتروني</p>
                        <p class="font-medium">{{ $university->email ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-gray-500 text-sm">رقم الهاتف</p>
                        <p class="font-medium" dir="ltr">{{ $university->phone ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-gray-500 text-sm">العنوان</p>
                        <p class="font-medium">{{ $university->address ?? '-' }}</p>
                    </div>
                    
                    @if($university->website)
                    <div>
                        <p class="text-gray-500 text-sm">الموقع الإلكتروني</p>
                        <a href="{{ $university->website }}" target="_blank" class="text-primary-600 hover:underline">
                            {{ $university->website }}
                        </a>
                    </div>
                    @endif
                    
                    <div class="pt-4 border-t">
                        <p class="text-gray-500 text-sm">تاريخ التسجيل</p>
                        <p class="font-medium">{{ $university->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- منطقة الخطر -->
            <div class="mt-6 bg-red-50 rounded-xl border border-red-200 p-6">
                <h3 class="text-lg font-bold text-red-800 mb-2">منطقة الخطر</h3>
                <p class="text-red-600 text-sm mb-4">حذف الجامعة سيؤدي إلى حذف جميع الشهادات المرتبطة بها.</p>
                <form action="{{ route('admin.universities.destroy', $university) }}" 
                      method="POST" 
                      onsubmit="return confirm('هل أنت متأكد من حذف هذه الجامعة؟ سيتم حذف جميع الشهادات المرتبطة بها!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 ml-1 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg> حذف الجامعة
                    </button>
                </form>
            </div>
        </div>

        <!-- آخر الشهادات -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <div class="flex justify-between items-center mb-4 pb-2 border-b">
                    <h2 class="text-lg font-bold text-gray-800">آخر الشهادات المضافة</h2>
                    <span class="text-sm text-gray-500">آخر 20 شهادة</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-700">رقم الشهادة</th>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-700">اسم الطالب</th>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-700">البرنامج</th>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-700">الحالة</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($university->certificates as $cert)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-sm font-mono">
                                    <a href="{{ route('certificate.show', $cert->certificate_number) }}" 
                                       target="_blank"
                                       class="text-primary-600 hover:underline">
                                        {{ $cert->certificate_number }}
                                    </a>
                                </td>
                                <td class="px-3 py-2 text-sm">{{ $cert->student_name_ar }}</td>
                                <td class="px-3 py-2 text-sm text-gray-600">{{ $cert->program_ar }}</td>
                                <td class="px-3 py-2">
                                    @if($cert->status === 'verified')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">معتمدة</span>
                                    @elseif($cert->status === 'pending')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">قيد المراجعة</span>
                                    @elseif($cert->status === 'suspended')
                                        <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full">موقوفة</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-gray-500">
                                    لا توجد شهادات حتى الآن
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
