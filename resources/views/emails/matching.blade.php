<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>وجدنا طلبات تبادل قد تناسبك</title>
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
            <h1>مركز تبادل</h1>
            <h1>وجدنا عروض تبادل قد تناسبك!</h1>
        </div>
        <div class="content">
            <p>عزيزي/عزيزتي {{ $offer->user->name }}</p>
            <p>بناء على طلبات تبادلكم وجدنا طلبات تبادل قد تناسبكم</p>
            <p>يمكنكم الاطلاع على التفاصيل عبر الرابط التالي:</p>
            <a href="{{ url('/offers/' . $offer->id) }}">عرض الطلب</a>
            <p>يمكنكم التواصل مع صاحب الطلب لاجل اتمام العملية!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} جميع الحقوق محفوظة.</p>
        </div>
    </div>
</body>

</html>
