<?php

// app/Http/Controllers/CertificateController.php
namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\VerificationLog;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function verifyForm()
    {
        return view('verify.form');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'certificate_number' => 'required|string',
        ]);

        $certificate = Certificate::with('university')
            ->where('certificate_number', $request->certificate_number)
            ->verified()
            ->first();

        if (!$certificate) {
            return back()->with('error', 'لم يتم العثور على شهادة بهذا الرقم');
        }

        // تسجيل عملية التحقق
        VerificationLog::create([
            'certificate_id' => $certificate->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'verification_source' => 'web',
            'verified_at' => now(),
        ]);

        return view('verify.result', compact('certificate'));
    }

    public function show($number)
    {
        $certificate = Certificate::with('university')
            ->where('certificate_number', $number)
            ->verified()
            ->firstOrFail();

        // تسجيل عملية التحقق
        VerificationLog::create([
            'certificate_id' => $certificate->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'verification_source' => 'direct_link',
            'verified_at' => now(),
        ]);

        return view('certificate.show', compact('certificate'));
    }
}