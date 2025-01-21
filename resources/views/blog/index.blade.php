@extends('layout.app')
@section('content')
    <!-- Hero Section -->
    <div class="hero">
        <div class="container">
            <h1>مرحبا بك على مدونة مركز تبادل</h1>
            <p class="lead">حيث نقدم معلومات تفيدك كموظف حول المدن، تغيير الوظيفة، الارتقاء المهني ...</p>
        </div>
    </div>

    <!-- Blog Posts and Categories -->
    <div class="container">
        <div class="row">
            <!-- Categories Sidebar -->
            <div class="col-md-3 bg-white py-3">
                <div class="d-grid">
                    <a href="{{ route('blog.article.create') }}" class="btn btn-primary mt-2 mb-2">
                        تحرير مقالة جديدة <i class="fa-solid fa-pen"></i>
                    </a>
                </div>
                <h4>الأقسام</h4>
                <div class="division-filter">
                    <a class="d-block py-2" href="{{ route('blog.index') }}">
                        رئيسية المدونة
                    </a>
                    @foreach ($divisions as $division)
                        <a class="d-block py-2"
                            href="{{ route('blog.index', ['division' => $division->id, 'category' => request('category')]) }}">
                            {{ $division->title }}
                        </a>
                    @endforeach
                </div>

                <h4 class="mt-4">التصنيفات</h4>
                <div class="category-filter text-center">
                    @foreach ($categories as $category)
                        <a class="btn btn-primary btn-xs"
                            href="{{ route('blog.index', ['category' => $category->id, 'division' => request('division')]) }}">
                            {{ $category->title }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Blog Posts -->
            <div class="col-md-9 mt-2">
                <div class="row">
                    @if (!empty($articles) && $articles->count() > 0)
                        @foreach ($articles as $article)
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <img src="{{ Storage::url($article->thumbnail) }}" class="card-img-top"
                                        alt="{{ $article->title }} - {{ $article->user->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $article->title }} - {{ $article->user->name }}</h5>
                                        <p class="card-text">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 90) }}
                                        </p>
                                        <div class="tags mb-2">
                                            <a
                                                href="{{ route('blog.index', ['category' => $category->id, 'division' => request('division')]) }}">#{{ $article->category->title }}</a>
                                        </div>
                                        <a href="{{ route('blog.article.show', ['slug' => $article->slug]) }}"
                                            class="btn btn-primary">مطالعة</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-6 mb-4 text-center justify-content-center mx-auto align-items-center">
                            <div class="alert alert-warning" role="alert">
                                لا توجد مقالات، إبدأ بتحرير مقالتك <a href="{{ route('blog.article.create') }}"
                                    class="btn btn-primary btn-sm mt-2 mb-2">
                                    تحرير مقالة جديدة <i class="fa-solid fa-pen"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                {{ $articles->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row bg-white p-5 text-center">
            <div class="col-md-4">
                <i style="font-size:4rem;" class="fa-solid fa-pen"></i>
            </div>
            <div class="col-md-8 text-right">
                <h3 class=" f-color bold mb-4 heading-text">حول المدونة - دراسة حالة</h3>
                <p class="supporting-text mb-5">
                    تنطلق فكرة مشروع ’’مدونة مركز تبادل‘‘ من الحاجة الماسة إلى مصدر موثوق للمعلومات التي تهم الموظفين حول
                    القرى والمدن المغربية.
                    <strong>الحل : </strong> مدونة تشاركية تعتمد على قرائها ونظام المراجعة لاجل توفير نسخ مستقرة من هذه
                    المقالات، بحيث يمكن للموظفين تغطية الخصاص الحاصل في هذا النوع من المعلومات عبر كتابة مقالة تغطي الجوانب
                    المهمة حول المدن والقرى المحتضنة لمقرات عملهم
                </p>
            </div>
        </div>
    </div>
@endsection

@section('extraJs')
    <style>
        .navbar {
            /*background-color: #04AA6D;*/
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: white !important;
        }

        .hero {
            background-color: #04AA6D;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card img {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            max-height: 260px;
        }

        .card-title {
            color: #04AA6D;
        }

        .footer {
            background-color: #04AA6D;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .btn-primary {
            background-color: #04AA6D;
            border: none;
        }

        .btn-primary:hover {
            background-color: #036d4e;
        }

        .tags a {
            text-decoration: none;
            margin-right: 10px;
            color: #04AA6D;
        }

        .tags a:hover {
            text-decoration: underline;
        }

        .division-filter {
            border-left: 5px solid #04aa6d;
            border-top: 1px solid #ccc;
        }

        .division-filter a {
            text-decoration: none;
            display: block;
            padding: 10px;
            color: #04AA6D;
            border-bottom: 1px solid #cccccc;
        }

        .division-filter a:hover {
            background-color: #e0e0e0;
        }
    </style>
@endsection
