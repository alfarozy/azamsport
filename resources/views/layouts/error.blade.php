<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="/frontoffice/img/fav.svg" type="image/x-icon" />

    <!-- Meta SEO -->
    <meta name="author" content="Muhammad Alfarozi">
    <meta name="theme-color" content="light">
    <!-- Bootstrap CSS -->
    <link href="/frontoffice/css/bootstrap.min.css" rel="stylesheet">
    <!-- library -->
    <link rel="stylesheet" href="/frontoffice/css/all.min.css" />
    <link rel="stylesheet" href="/frontoffice/css/style.css" />
    <link rel="stylesheet" href="/frontoffice/css/responsive.css" />
    <title>@yield('title')</title>
    @yield('style')
</head>

<body>
    <!-- ======================== start Main ======================== -->
    <div class="header">
        <div class="main-menu">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="/frontoffice/img/logo.png" alt="logo alfarozy.id" srcset="" />
                    </a>
                    <button class="navbar-toggler border-white" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <div class="m-auto"></div>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/#about">about</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/#skill">skill</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="/#portfolio">portfolio</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('homepage.posts') }}">blog</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/#contact">contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <main>
        @yield('content')

    </main>
    <!-- ======================== end Main ======================== -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="/frontoffice/js/vendore/bootstrap.bundle.min.js"></script>
    <script src="/frontoffice/js/vendore/jquery-3.6.0.slim.min.js"></script>
    <script src="/frontoffice/js/vendore/all.min.js"></script>

</body>

</html>
