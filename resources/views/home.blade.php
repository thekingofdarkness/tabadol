@extends('layout.app')

@section('content')
    <!-- Hero Section Start -->
    <section class="hero-section p-5 bg-gradient-main text-white">
        <div class="row">
            <div class="col-sm-12 text-center mb-2">
                <h1>
                    Movementsalarie.com منصة لكل الأساتذة الراغبين في الانتقال لمدينة جديدة!
                </h1>
                <p>تبادل و انتقل، واخدم براحتك !</p>
                <a href="#howto" class="btn btn-light mt-1">كيف تشتغل المنصة ؟</a>
                <a href="{{ route('offers.create') }}" class="btn btn-warning mt-1">أضف طلبك</a>
            </div>
            <div class="col-sm-12 d-flex justify-content-center align-items-center">
                <form class="bg-faded-white mt-2 p-3 d-flex flex-wrap justify-content-center align-items-center w-100"
                    action="{{ route('home') }}" method="GET" dir="rtl">
                    <div class="input-group mb-2 mb-sm-0">
                        <input class="form-control rounded-0 mb-2 mb-sm-0" type="search"
                            placeholder="إبحث بالمدينة، المؤسسة ..." aria-label="Search" value="{{ request('search') }}"
                            name="search" />
                        <select class="form-select rounded-0 mb-2 mb-sm-0" name="cadre" id="filterDropdown">
                            <option value="">البحث حسب الاطار</option>
                            @foreach ($frameworks as $framework)
                                <option value="{{ $framework->codename }}"
                                    {{ request('cadre') == $framework->codename ? 'selected' : '' }}>
                                    {{ $framework->arabic_name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-search"></i> بحث
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->
<div class="container my-2 py-2 bg-light rounded text-center" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
    <strong style="font-size: 1.75rem;" class="mb-4">حساباتنا الرسمية</strong>
    <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
        <a href="https://chat.whatsapp.com/IvhBiTiSdRP06CfjN7sIIw" target="_blank" class="btn btn-success btn-lg" style="background-color: #25D366; border-color: #25D366;" rel="nofollow">مركز تبادل المعلومات حول المؤسسات</a>
        <a href="https://chat.whatsapp.com/C3cyc5ZLzfw30o04HSRN0z" target="_blank" class="btn btn-success btn-lg" style="background-color: #25D366; border-color: #25D366;" rel="nofollow">مركز التبادل - السلك التأهيلي</a>
        <a href="https://chat.whatsapp.com/DSSzv9oliflEgo4SctKqLa" target="_blank" class="btn btn-success btn-lg" style="background-color: #25D366; border-color: #25D366;" rel="nofollow">مركز التبادل - السلك الاعدادي</a>
        <a href="https://chat.whatsapp.com/Jt2CPDqIFF4C9BEwwZwaJU" target="_blank" class="btn btn-success btn-lg" style="background-color: #25D366; border-color: #25D366;" rel="nofollow">مركز التبادل - السلك الابتدائي</a>
        <a href="https://chat.whatsapp.com/IZPwZMVDFmYFLk9ycVMls6" target="_blank" class="btn btn-success btn-lg" style="background-color: #25D366; border-color: #25D366;" rel="nofollow">مركز التبادل - الاطر المختصة</a>
        <a href="https://www.facebook.com/groups/836056125118209" class="btn btn-primary btn-lg" style="background-color: #3b5998; border-color: #3b5998;" target="_blank" rel="nofollow">مركز التبادل - مجموعة الفايسبوك</a>
    </div>
</div>

    <!--position general_index_under_hero start-->
    {!! $general_index_under_hero !!}
    <!--join ourwhhatsapp group ends-->
    <!--Offers section start-->
    <section id="OffersListing" class="how-to-section px-0 py-5 bg-md-blue ">
        <div class="container">
            <div class="row">
                @if (!empty($offers) && $offers->count() > 0)
                    @foreach ($offers as $offer)
                        <!-- Start offer -->
                        <div class="col-12 mb-2">
                            <div class="card job-listings-item">
                                <div class="card-body">
                                    <div class="row d-flex flex-md-row flex-column align-items-center">
                                        <div class="job-main-info col-lg-10">
                                            <div class="job-main-group d-flex align-items-center">
                                                <div class="job-employer-logo mr-md-3 mr-0">
                                                    <img src="{{ asset('imgs/alter.png') }}" alt="Company Logo">
                                                </div>
                                                <div class="job-details-group">

                                                    <a href="{{ route('offers.show', $offer->id) }}"
                                                        style="text-decoration:none; color:#000;">
                                                        <div class="job-details">
                                                            <h3>
                                                                طلب تبادل {{ $offer->current_cadre }} الانتقال من
                                                                {{ $offer->current_commune }}
                                                                إلى مديرية {{ $offer->required_dir }} جماعة
                                                                {{ $offer->required_commune }}
                                                            </h3>
                                                            <ul class="job-details-content">
                                                                <li>
                                                                    <i class="fa-solid fa-building-columns"></i>
                                                                    {{ $offer->current_aref }}
                                                                </li>
                                                                <li>
                                                                    <i class="fas fa-map-marker-alt"></i> نحو
                                                                </li>
                                                                <li>
                                                                    <i class="fa-solid fa-building-columns"></i>
                                                                    {{ $offer->required_aref }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </a>
                                                    <div class="job-tags">
                                                        <a href="#" class="job-tag mt-1">
                                                            {{ $offer->speciality }}
                                                        </a>
                                                        <a href="#" class="job-tag mt-1">
                                                            {{ $offer->current_commune }}
                                                        </a>
                                                        <a href="#" class="job-tag mt-1">
                                                            {{ $offer->current_dir }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="job-meta-info col-lg-2">
                                            <div class="job-posted-date">
                                                <i class="far fa-clock mr-3"></i>
                                                {{ $offer->created_at->locale('ar')->diffForHumans() }}
                                                <div class="d-block">
                                                    @if ($offer->status == 'approved')
                                                        <div class="badge bg-success"> يستقبل العروض</div>
                                                    @elseif($offer->status == 'expired')
                                                        <div class="badge bg-danger"> منتهي</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <a href="{{ route('offers.show', $offer->id) }}" class="btn mt-2">
                                                <i class="fas fa-file-signature"></i> تفاصيل
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End offer -->
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info text-center" role="alert">
                            لا توجد طلبات متاحة حاليا <a href="{{ route('offers.create') }}" class="btn btn-primary">أضف
                                طلبا الان</a>
                        </div>
                    </div>
            </div>
            @endif
        </div>
        <!-- Pagination -->
        @if ($offers->hasPages())
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                    <!-- Previous Page Link -->
                    @if (!$offers->onFirstPage())
                        <li class="page-item  d-none d-sm-block">
                            <a class="page-link"
                                href="{{ $offers->appends(request()->except('page'))->previousPageUrl() }}" rel="prev">
                                @lang('pagination.previous')
                            </a>
                        </li>
                    @endif

                    <!-- Pagination Elements -->
                    @php
                        $current = $offers->currentPage();
                        $last = $offers->lastPage();
                        $start = max(1, $current - 2);
                        $end = min($last, $current + 3);

                        $showStartEllipsis = $start > 2;
                        $showEndEllipsis = $end < $last - 1;
                    @endphp

                    <!-- First Page Link -->
                    @if ($start > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $offers->appends(request()->except('page'))->url(1) }}">1</a>
                        </li>
                        @if ($showStartEllipsis)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    <!-- Page Links -->
                    @for ($page = $start; $page <= $end; $page++)
                        <li class="page-item {{ $page == $current ? 'active' : '' }}">
                            <a class="page-link" href="{{ $offers->appends(request()->except('page'))->url($page) }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endfor

                    <!-- Last Page Link -->
                    @if ($end < $last)
                        @if ($showEndEllipsis)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ $offers->appends(request()->except('page'))->url($last) }}">
                                {{ $last }}
                            </a>
                        </li>
                    @endif

                    <!-- Next Page Link -->
                    @if ($offers->hasMorePages())
                        <li class="page-item d-none d-sm-block">
                            <a class="page-link" href="{{ $offers->appends(request()->except('page'))->nextPageUrl() }}"
                                rel="next">
                                @lang('pagination.next')
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        @endif



    </section>
    <!--Offers section end-->
    <!-- Latest blog posts start -->
    <section id="posts-section" class="px-0 py-5 bg-white">
        <div class="container">
            <div class="section-header d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">اخر المقالات المنشورة</h2>
                <a href="{{ route('blog.index') }}" class="btn btn-primary border-0 btn-read-more">زيارة المدونة</a>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($articles as $article)
                    <!-- Post Item -->
                    <div class="col mb-4">
                        <div class="card h-100">
                            <img src="{{ Storage::url($article->thumbnail) }}" class="card-img-top"
                                alt="{{ $article->title }} - {{ $article->user->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->title }} - {{ $article->user->name }}</h5>
                                <p class="card-text">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 90) }}</p>
                                <a href="{{ route('blog.article.show', ['slug' => $article->slug]) }}"
                                    class=" btn btn-primary border-0 btn-read-more">مطالعة</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Latest blog posts end -->

    <!--How To section start-->
    <section id="howto" class="how-to-section border-top bg-white px-0 py-5 bg-md-blue mb-0">
        <div class="container">
            <h2 class="f-orange text-center pb-4">ماذا يمكنك فعله على المنصة ؟</h2>
            <div class="row">
                <div class="col-sm-4 mt-1">
                    <a href="{{ route('login') }}" style="text-decoration:none; color:white;">
                        <div class="card bg-dark text-white how-to-card text-center h-100">
                            <div class="card-body">
                                <div class="how-to-icon display-3 p-5">
                                    <i class="fa-regular fa-paper-plane"></i>
                                </div>
                                <div class="f-bold f-blue text-center">
                                    <p>أنشئ حسابك أو سجل الدخول لتتمكن من اضافة طلبات تبادل او تقديم عروض</p>
                                    <a name="login" id="login" class="btn btn-secondary"
                                        href="{{ route('login') }}" role="button">تسجيل الدخول / انشاء حساب</a>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-4 mt-1">
                    <div class="card bg-secondary text-white how-to-card text-center h-100">
                        <div class="card-body">
                            <div class="how-to-icon display-3 p-5">
                                <i class="fa-solid fa-crosshairs"></i>
                            </div>
                            <div class="f-bold f-blue text-center">
                                <strong> تصفح العروض و التواصل مع اصحابها، أو انشاء عروض خاصة بكم</strong></br>
                                <a name="" id="" class="btn btn-dark"
                                    href="{{ route('offers.create') }}" role="button">إضافة عرض</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mt-1">
                    <div class="card bg-dark text-white how-to-card text-center h-100">
                        <div class="card-body">
                            <div class="how-to-icon display-3 p-5">
                                <i class="fa-solid fa-pen"></i>
                            </div>
                            <div class="f-bold f-blue text-center">
                                <strong> تقاسم المعلومات حول أماكن التعيين و المستجدات التي تهم الموظفين</strong></br>
                                <a name="" id="" class="btn btn-secondary"
                                    href="{{ route('blog.article.create') }}" role="button">كتابة مقالة</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--How to section end-->
@endsection
