@extends('layout.app')

@section('page.title',
    "عرض طلب {$offer->current_cadre} الانتقال من {$offer->current_commune} إلى مديرية
    {$offer->required_dir} جماعة {$offer->required_commune}")
@section('og:title',
    "عرض طلب {$offer->current_cadre} الانتقال من {$offer->current_commune} إلى مديرية
    {$offer->required_dir} جماعة {$offer->required_commune}")
@section('og:description',
    "عرض طلب {$offer->current_cadre} الانتقال من {$offer->current_commune} إلى مديرية
    {$offer->required_dir} جماعة {$offer->required_commune}")
@section('content')
    <div class="container bg-white pt-3 pb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb rounded">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a>عرض طلب </a></li>
            </ol>
        </nav>
        <div class="alert alert-info" role="alert">
            إضغط على زر تقديم عرض لاجل التواصل مع صاحب الطلب
        </div>
        <div class="card mb-3">

            <h5 class="card-header bg-secondary text-white">طلب {{ $offer->current_cadre }} الانتقال من
                {{ $offer->current_commune }}
                إلى مديرية {{ $offer->required_dir }} جماعة
                {{ $offer->required_commune }}</h5>
            <div class="card-body">
                <div class="row pb-3">
                    <div class="col-12 mt-2">

                        @if (
                            (Auth::check() && Auth::user()->id != $offer->uid && $offer->status_en === 'approved') ||
                                (Auth::guest() && $offer->status_en === 'approved'))
                            <div id="form">
                                <a role="button" class="btn btn-labeled btn-info text-left d-block d-md-inline-block"
                                    href="{{ route('bids.create', $offer->id) }}">
                                    <span class="btn-label">
                                        <i class="fa-solid fa-hand-point-up"></i>
                                    </span>
                                    تقديم عرض
                                </a>
                            </div>
                        @endif


                    </div>
                    <!-- URL Display - Visible only on phones -->
                    <div class="d-block  d-sm-none mt-2 pb-3">
                        <p><strong>شارك رابط العرض : </strong> <span id="url-display"><input class="form-control mt-1"
                                    value="{{ url()->current() }}" disabled></span></p>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <th scope="row">صاحب الطلب</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">الاطار</th>
                            <td>{{ $offer->current_cadre }}</td>
                        </tr>
                        <tr>
                            <th scope="row">التخصص</th>
                            <td>{{ $offer->speciality }}</td>
                        </tr>
                        <tr class="from">
                            <th scope="row">من أكاديمية</th>
                            <td>{{ $offer->current_aref }}</td>
                        </tr>
                        <tr class="from">
                            <th scope="row">مديرية</th>
                            <td>{{ $offer->current_dir }}</td>
                        </tr>
                        <tr class="from">
                            <th scope="row">جماعة</th>
                            <td>{{ $offer->current_commune }}</td>
                        </tr>
                        <tr class="from">
                            <th scope="row">مؤسسة</th>
                            <td>{{ $offer->current_institution }}</td>
                        </tr>
                        <tr class="to">
                            <th scope="row">الاكاديمية المطلوبة</th>
                            <td>{{ $offer->required_aref }}</td>
                        </tr>
                        <tr class="to">
                            <th scope="row">مديرية</th>
                            <td>{{ $offer->required_dir }}</td>
                        </tr>
                        <tr class="to">
                            <th scope="row">جماعة</th>
                            <td>{{ $offer->required_commune }}</td>
                        </tr>
                        <tr class="to">
                            <th scope="row">المؤسسة</th>
                            <td>{{ $offer->required_institution }}</td>
                        </tr>
                        <tr>
                            <th scope="row">ملاحظة</th>
                            <td>{{ $offer->note }}</td>
                        </tr>
                        <tr>
                            <th scope="row">وضعية الطلب</th>
                            <td>{{ $offer->status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>
@endsection
