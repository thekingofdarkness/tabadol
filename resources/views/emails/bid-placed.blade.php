<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>عرض جديد على طلبكم</title>
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
            <h2>تم وضع عرض على طلبكم!</h2>
        </div>
        <div class="content">
            <p>عزيزي/عزيزتي {{ $bid->offer->user->name }}</p>
            <p>نحن نود إبلاغكم بأنه تم وضع عرض جديد على طلبكم رقم <strong>{{ $bid->offer_id }}</strong>.</p>
            <p><strong>تفاصيل العرض:</strong></p>
            <ul>
                <li>مقدم العرض: {{ $bid->bidder->name }}</li>
                <li>تاريخ العرض: {{ $bid->created_at->format('d/m/Y H:i') }}</li>
                <li>التفاصيل: {{ $bid->details }}</li>
            </ul>
            <p>يمكنكم الاطلاع على تفاصيل الطلب عبر الرابط التالي:</p>
            <a href="{{ url('/rec-bids/' . $bid->offer_id) }}">عرض الطلب</a>
            <p>يمكنكم الآن متابعة العرض والتواصل مع مقدم العرض إذا لزم الأمر.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} مركز تبادل. جميع الحقوق محفوظة.</p>
        </div>
    </div>
</body>

</html>
