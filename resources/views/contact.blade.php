{{-- resources/views/contact.blade.php --}}
@extends('layouts.app')

@section('title', 'تواصل معنا')

@section('content')
<div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8">

    {{-- النموذج --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6">تواصل معنا</h1>

        <form action="{{ route('contact.post') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-gray-700 font-medium mb-2">الاسم الكامل</label>
                <input 
                    type="text" 
                    name="name" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-600 transition" 
                    required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">البريد الإلكتروني</label>
                <input 
                    type="email" 
                    name="email" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-600 transition"
                    required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">الموضوع</label>
                <input 
                    type="text" 
                    name="subject" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-600 transition"
                    required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">الرسالة</label>
                <textarea 
                    name="message" 
                    rows="5"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-600 transition"
                    required></textarea>
            </div>

            <button type="submit" class="w-full bg-gray-900 text-white py-3 text-lg rounded-lg font-semibold hover:bg-primary-800 transition shadow">
                 إرسال الرسالة
            </button>
        </form>
    </div>

    {{-- معلومات التواصل + الخريطة --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 flex flex-col justify-between">
        
        <div>
            <h2 class="text-2xl font-extrabold text-gray-900 mb-6">معلومات الاتصال</h2>

            <div class="space-y-4 text-gray-700">
                <p><strong>📧 البريد:</strong> info@mohe.gov.sd</p>
                <p><strong>☎️ الهاتف:</strong> +249 123 456 789</p>
                <p><strong>🏛️ العنوان:</strong> وزارة التعليم العالي — الخرطوم، السودان</p>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-xl font-bold text-gray-900 mb-3">موقعنا على الخريطة</h3>

            <!-- Google Maps Embed -->
            <div class="rounded-lg overflow-hidden border border-gray-300 shadow-sm">
                <iframe 
                    width="100%" 
                    height="250" 
                    frameborder="0" 
                    scrolling="no" 
                    marginheight="0" 
                    marginwidth="0"
                    src="https://www.google.com/maps?q=Ministry+of+Higher+Education+Sudan&output=embed
">
                </iframe>
            </div>
        </div>

    </div>

</div>
@endsection
