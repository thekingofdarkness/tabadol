<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>قبول عرضكم</title>
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
            background-color: #28a745;
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
            <h2>عرضكم تم قبوله!</h2>
        </div>
        <div class="content">
            <p>عزيزي/عزيزتي {{ $bid->bidder->name }}</p>
            <p>نحن سعداء بأن نعلن أن عرضكم على الطلب رقم <strong>{{ $bid->offer_id }}</strong> قد تم قبوله.</p>
            <p>تم فتح نقاش بخصوص عرضكم. يمكنكم متابعة النقاش عبر الرابط التالي:</p>
            <a href="{{ url('/chat/' . $bid->chatRoom->id) }}">عرض النقاش</a>
            <p>يمكنكم الآن التواصل مع الطرف الآخر بخصوص العرض.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} مركز تبادل. جميع الحقوق محفوظة.</p>
        </div>
    </div>
</body>

</html>
