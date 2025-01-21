@extends('layout.app')

@section('page.title', 'تقديم عرض')
@section('content')
<div class="container bg-white pt-3 pb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb rounded">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            <li class="breadcrumb-item"><a>تقديم عرض</a></li>
        </ol>
    </nav>
    <div class="alert alert-warning" role="alert">
        المرجو التأكد من وضع ملاحظة جيدة توافق المعايير التالية التي  نوصي بها :
        <ul>
            <li>أن تكون واضحة و مركزة</li>
            <li>لا تشارك معطياتك الحساسة مع الشخص الاخر - راسلنا في حالة سوء استخدام</li>
            <li>حفاظا على استقرار المعاملات بالمنصة، بمجرد إرسال العرض لايمكن تعديله ولا حذفه</li>
            <li>تابع وضعية عرضك عبر لوحة التحكم الخاصة بك <a href="{{route('bids.mylist')}}" class="btn btn-sm btn-primary">عروضي</a></li>
        </ul>
    </div>
    @if (!$hasBid)
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bids.store') }}" method="POST">
        @csrf
        <input type="hidden" name="offer_id" value="{{ $offer->id }}">
        <div class="form-group">
            <label for="note">متن العرض :</label>
            <textarea name="note" class="form-control" id="note" required>{{ old('note') }}</textarea>
        </div>
        <button type="submit" class="btn btn-success mt-2">إرسال عرض</button>
    </form>
</div>
@else
    <table class="table table-bordered table-light">
        <tbody>
            <tr>
                <td class="text-center" colspan="2">تفاصيل العرض الذي قدمته بتاريخ : {{$bid->created_at}}</td>
            </tr>
            <tr>
                <td>عنوان العرض :</td>
                <td>طلب {{$offer->current_cadre}} الانتقال من {{$offer->current_commune}} إلى مديرية {{$offer->required_dir}} جماعة {{$offer->required_commune}}</td>
            </tr>
            <tr>
                <td>الملاحظة المرفقة</td>
                <td>{{$bid->note}}</td>
            </tr>
            <tr>
                <td>وضعية العرض</td>
                <td>{{$bid->status_ar}}</td>
            </tr>
            @if ($bid->status == "accepted")
            <tr>
                <td>غرفة المحادثة</td>
                <td><a href="{{route('chat.index', $bid->chatroom->id)}}" class="btn btn-primary">chat</a></td>
            </tr>
            @endif
        </tbody>
    </table>
@endif
@endsection
