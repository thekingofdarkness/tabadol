@extends('layout.app')

@section('page.title', 'إدارة عروضي')
@section('content')
    <div class="container bg-white pt-3 pb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb rounded">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('offers.index') }}">إدارة طلباتي</a></li>
                <li class="breadcrumb-item"><a>إدارة العروض التي قدمتها</a></li>
            </ol>
        </nav>

        @if ($bids->isEmpty())
            <p>لم تقدم أي عروض بعد</p>
        @else
            <div class="alert alert-info" role="alert">
                <strong>ملاحظة :</strong> بمجرد الضغط على زر مناقشة العرض يتم فتح غرفة النقاش لأول مرة مع الطرف الاخر، ويتم إشعاره بذلك
            </div>
            <table class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th class="d-none d-sm-block">معرف العرض</th>
                        <th>مقدم العرض</th>
                        <th>الملاحظات</th>
                        <th>بتاريخ</th>
                        <th>المهام</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bids as $bid)
                        <tr>
                            <td class="d-none d-sm-block">{{ $bid->offer_id }}</td>
                            <td>{{ $bid->bidder->name }}</td>
                            <td>{{ $bid->note }}</td>
                            <td>{{ $bid->created_at }}</td>
                            <td>
                                @if($bid->status === "pending")
                                <form action="{{ route('bids.accept', $bid->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        غرفة النقاش <span
                                            class="badge badge-light">{{ $bid->chatRoom ? $bid->chatRoom->unreadMessagesCount() : 0 }}</span>
                                        <span class="sr-only">unread messages</span>
                                    </button>
                                </form>
                                @else
                                <a href="{{route('chat.index', $bid->chatRoom->id)}}" class="btn btn-primary">
                                    غرفة النقاش <span
                                        class="badge badge-light">{{ $bid->chatRoom ? $bid->chatRoom->unreadMessagesCount() : 0 }}</span>
                                    <span class="sr-only">unread messages</span>
                                </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
