<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * عرض الصفحة الرئيسية
     */
    public function index()
    {
        $stats = [
            'total_certificates' => Certificate::count(),
            'total_universities' => University::active()->count(),
            'total_verifications' => \App\Models\VerificationLog::count(),
        ];
        
        return view('home', compact('stats'));
    }
    
    /**
     * عرض صفحة التواصل
     */
    public function contact()
    {
        return view('contact');
    }
    
    /**
     * معالجة نموذج التواصل
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ], [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'subject.required' => 'الموضوع مطلوب',
            'message.required' => 'الرسالة مطلوبة',
        ]);
        
        // إرسال البريد الإلكتروني
        try {
            Mail::to('info@mohe.gov.sd')->send(
                new \App\Mail\ContactMessage($validated)
            );
            
            return back()->with('success', 'تم إرسال رسالتك بنجاح. سنتواصل معك قريباً.');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء إرسال الرسالة. الرجاء المحاولة لاحقاً.');
        }
    }
}