<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-size: 0.9rem;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            background-color: #343a40;
            padding-top: 1rem;
        }

        .sidebar a {
            color: #adb5bd;
            display: block;
            padding: 0.75rem 1rem;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: #fff;
        }

        .main-content {
            margin-left: 250px;
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h4 class="text-white text-center">Admin Panel</h4>
        <a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
        <a href="{{ route('admin.wsettings.index') }}">Website Settings</a>
        <a href="{{ route('admin.dashboard.users') }}">Users</a>
        <a href="{{ route('admin.runMatchingLogic') }}">Run Matching Logic</a>

        <a href="{{ route('admin.offers.index') }}">Offers</a>
        <a href="{{ route('admin.frameworks.index') }}">Framewokrs</a>
        <a href="{{ route('admin.chatRooms') }}">ChatRooms</a>
        <a href="{{ route('admin.blogs') }}">blogs</a>
        <a href="{{ route('admin.blogs.divisions') }}">blogs/Division</a>
        <a href="{{ route('admin.blogs.categories') }}">Division/Category</a>
        <a href="{{ route('admin.blogs.articles.review') }}">Articles Review</a>
    </div>
    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    @yield('scripts')
</body>

</html>
