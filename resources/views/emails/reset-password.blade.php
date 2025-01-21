<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>إعادة تعيين كلمة المرور</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Add custom styles here */
        .email-container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align:right;
        }

        .header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            padding: 20px;
        }

        .footer {
            text-align: center;
            padding: 10px;
            border-top: 1px solid #ddd;
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>إعادة تعيين كلمة المرور</h1>
        </div>
        <div class="content">
            <p>عزيزي/عزيزتي {{ $notifiable->name }},</p>
            <p>تلقّيتم هذه الرسالة لأننا تلقينا طلب إعادة تعيين كلمة المرور لحسابكم.</p>
            <p>يمكنكم إعادة تعيين كلمة المرور عبر الرابط التالي:</p>
            <a href="{{ url(config('app.url') . route('password.reset', $token, false)) }}">إعادة تعيين كلمة المرور</a>
            <p>إذا لم تطلبوا إعادة تعيين كلمة المرور، فلا حاجة لاتخاذ أي إجراء.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} مركز تبادل. جميع الحقوق محفوظة.</p>
        </div>
    </div>
</body>

</html>
