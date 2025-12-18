<?php

// app/Services/QRCodeService.php
namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class QRCodeService
{
    public function generate($certificate)
    {
        $url = route('certificate.show', $certificate->certificate_number);
        
        // إنشاء QR Code بصيغة SVG (لا تتطلب imagick)
        $qrCode = QrCode::format('svg')
                        ->size(300)
                        ->errorCorrection('H')
                        ->generate($url);
        
        // حفظ الصورة
        $filename = 'qrcodes/' . $certificate->certificate_number . '.svg';
        Storage::disk('public')->put($filename, $qrCode);
        
        return $filename;
    }
    
    
}