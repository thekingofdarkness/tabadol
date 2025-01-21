@extends('layout.app')

@section('page.title', 'إدارة عروضي')
@section('content')
    <div class="container bg-white pt-3 pb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb rounded">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a>إدارة العروض التي قدمتها</a></li>
            </ol>
        </nav>

        @if ($bids->isEmpty())
            <p>لم تقدم أي عروض بعد</p>
        @else
            <div class="alert alert-info" role="alert">
                عند قيام صاحب طلب العروض بحذف طلبه، يتم تلقائيا إغلاق جميع غرف المحادثة المتصلة بها و يتم حذف سجل المحادثات
                المتصلة بها بشكل نهائي، ولا يمكن عكس العملية
            </div>
            <div class="alert alert-info" role="alert">
                في خانة المهام، لا يظهر زر ’’غرفة النقاش‘‘ إلا بعد قبول صاحب الطلب للعرض الذي قدمته له. إحرص ان تكون
                الملاحظة الذي ترفقها بعرضك وافية الشرح للرفع من حظوظ قبول عروضك.
            </div>
            <table class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>معرف العرض</th>
                        <th>مقدم العرض</th>
                        <th>الملاحظات</th>
                        <th>الحالة</th>
                        <th>بتاريخ</th>
                        <th>المهام</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bids as $bid)
                        <tr>
                            <td>{{ $bid->offer_id }}</td>
                            <td>{{ $bid->bidder->name }}</td>
                            <td>{{ $bid->note }}</td>
                            <td>{{ $bid->status_ar }}</td>
                            <td>{{ $bid->created_at }}</td>
                            <td>
                                @if ($bid->status === 'accepted')
                                    <a href="{{route('chat.index', $bid->chatRoom->id)}}" class="btn btn-primary">
                                        غرفة النقاش <span
                                            class="badge badge-light">{{ $bid->chatRoom ? $bid->chatRoom->unreadMessagesCount() : 0 }}</span>
                                        <span class="sr-only">unread messages</span>
                                    </a>
                                @else
                                    -------
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
