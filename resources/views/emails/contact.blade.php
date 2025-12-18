{{-- resources/views/emails/contact.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #15803d; color: white; padding: 20px; text-align: center; }
        .content { background: #f9fafb; padding: 20px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>رسالة جديدة من موقع التحقق من الشهادات</h2>
        </div>
        <div class="content">
            <p><strong>الاسم:</strong> {{ $data['name'] }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $data['email'] }}</p>
            <p><strong>الموضوع:</strong> {{ $data['subject'] }}</p>
            <p><strong>الرسالة:</strong></p>
            <p>{{ $data['message'] }}</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} وزارة التعليم العالي والبحث العلمي</p>
        </div>
    </div>
</body>
</html>