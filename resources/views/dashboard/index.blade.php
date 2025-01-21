@extends('layout.app')
@section('content')
    <main>
        <div class="container pt-2 pb-5 bg-md-blue">
            <div class="card card-success">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-2 mb-1 rounded">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a>لوحة التحكم</a></li>
                    </ol>
                </nav>
                <div class="card-body">
                    <div class="alert alert-info">
                        <p class="f-16"> لوحة التحكم : يمكنك من خلالها متباعة طلبات عروضكم،و العروض التي قدمتموها كما
                            يمكنكم من خلالها تغيير كلمة السر ومعلومات حسابكم
                        </p>
                    </div>
                    <div class="row text-center mx-auto mt-4 pt-2">
                        <div class="col-12 col-md-4 mb-1 tasks">
                            <a href="{{ route('dashboard.account') }}">
                                <div class="card">
                                    <div class="card-body bg-primary text-white">
                                        <div class="d-flex justify-content-between px-md-1">
                                            <div>
                                                <h3>إعدادات حسابي</h3>
                                                <p class="mb-0">تغيير معلوماتي</p>
                                                <p class="mb-0">تغيير كلمة السر</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-user-cog fa-3x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-4 mb-1 tasks">
                            <a href="{{ route('offers.index') }}">
                                <div class="card">
                                    <div class="card-body bg-primary text-white">
                                        <div class="d-flex justify-content-between px-md-1">
                                            <div>
                                                <h3>طلباتي للتبادل&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </h3>
                                                <p class="mb-0">إضافة طلب للتبادل</p>
                                                <p class="mb-0">ادارة طلباتي للتبادل</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-exchange-alt text-whte fa-3x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-md-4 mb-1 tasks">
                            <!--a href="http://tabadol.test/account" class="btn btn-primary d-flex align-items-center justify-content-center btn-lg-dash">
                                                                    <i class="fas fa-user"></i> &nbsp; Account Settings
                                                                </a-->
                            <a href="{{ route('bids.mylist') }}">
                                <div class="card">
                                    <div class="card-body bg-primary text-white">
                                        <div class="d-flex justify-content-between px-md-1">
                                            <div>
                                                <h3>العروض التي قدمتها&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
                                                <p class="mb-0">تصفح عروضي</p>
                                                <p class="mb-0">الوصول إلى غرف النقاش</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="far fa-comments text-whte fa-3x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @if ($userDashboardIndexNote)
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header bg-danger text-white">ملاحظات ادارية :</div>
                                    <div class="card-body">
                                        {!! $userDashboardIndexNote !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>


    </main>
@endsection
