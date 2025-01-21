<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('page.title', 'مركز تبادل')</title>
    <meta name="description" content="@yield('meta_description', 'منصة مصممة لتسهيل عملية التبادل بين الموظفين')">
    <meta name="keywords" content="@yield('meta_keywords', 'الحركة الانتقالية, الحركة التعليمية, التعليم, التبادل')">
    <meta name="author" content="Abderrahman bouichou">
    <script src="https://kit.fontawesome.com/69f388b246.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=0.2" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('imgs/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imgs/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('imgs/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og:title', 'مركز التبادل')" />
    <meta property="og:description" content="@yield('og:description', 'منصة مصممة لتسهيل تنسيق عملية التبادل بين الموظفين')" />
    <meta property="og:image" content="@yield('og:image', asset('imgs/thumbn.png'))" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="314" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="مركز التبادل" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-SMDBBJ54J1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-SMDBBJ54J1');
    </script>
</head>

<body class="d-flex flex-column vh-100">
    <!--top nav start-->
    <div class="navbar navbar-costume-top">
        <a class="active" href="{{ route('home') }}"><i class="fa fa-fw fa-home"></i> <span class="d-none d-sm-inline">الرئيسية</span></a>
        <!--guest nav start-->
        @guest
            <a href="{{ route('login') }}"><i class="fa fa-fw fa-user"></i> دخول</a>
            <a href="{{ route('register') }}"><i class="fa-solid fa-user-plus"></i> تسجيل</a>
            <!--guest nav ends-->
        @else
            {{-- Auth nav start --}}
            <a id="notificationsDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                onclick="fetchNotifications('#notifications')">
                <i class="fas fa-bell"></i>
                <span class="badge bg-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-start dropdown-dark" aria-labelledby="notificationsDropdown"
                id="notifications"></div>
            <div class="dropdown">
                <button class="btn dropdown-toggle text-white" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropindark" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                    <li><a class="dropdown-item text-dark" href="{{ route('logout') }}">تسجيل الخروج</a></li>
                </ul>
            </div>
            {{-- Auth nav ends --}}
            @endif
        </div>
        <!--top nav ends-->

        @yield('content')


        <footer class="bg-darkish text-lighpy-3 py-4 mt-auto">
            <ul class="nav justify-content-center border-bottom text-light pb-3 mb-3">
                <li class="nav-item"><a href="{{ route('pages.about_us') }}" class="nav-link px-2">من نحن ؟</a></li>
                <li class="nav-item"><a href="{{ route('pages.privacy') }}" class="nav-link px-2">سياسة الخصوصية</a></li>
                <li class="nav-item"><a href="{{ route('pages.usage_agreement') }}" class="nav-link px-2">إتفاقية
                        الاستخدام</a></li>
                <li class="nav-item"><a href="{{ route('pages.team') }}" class="nav-link px-2">فريق العمل</a></li>
                <li class="nav-item"><a href="{{ route('pages.contact') }}" class="nav-link px-2">إتصل بنا</a></li>
            </ul>
            <p class="text-center">&copy; {{ date('Y') }} جميع الحقوق محفوظة.</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        @auth
            <script>
                // Ensure the functions are in the global scope
                function fetchUnreadNotificationsCount() {
                    $.ajax({
                        url: '{{ route('notifications.unreadCount') }}',
                        method: 'GET',
                        success: function(data) {
                            var badge = document.querySelector('#notificationsDropdown .badge');
                            if (data.unread_count > 0) {
                                badge.textContent = data.unread_count;
                                badge.style.display = 'inline-block';
                            } else {
                                badge.style.display = 'none';
                            }
                        },
                        error: function(response) {
                            console.error('Error:', response);
                        }
                    });
                }

                function fetchNotifications(id) {
                    $.ajax({
                        url: '{{ route('notifications.get') }}',
                        method: 'GET',
                        success: function(response) {
                            $(id).html(response.html);
                        },
                        error: function(response) {
                            console.error('Error:', response);
                        }
                    });
                }

                document.addEventListener("DOMContentLoaded", function() {
                    // Fetch the unread notifications count every 30 seconds
                    setInterval(fetchUnreadNotificationsCount, 30000);

                    // Initial fetch when the page loads
                    fetchUnreadNotificationsCount();
                });
            </script>
            @endif

            @yield('extraJs')
        </body>

        </html>
