<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Jobber - Job Board HTML5 Template" />
    <meta name="author" content="potenzaglobalsolutions.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />
    <base href="{{ asset('/') }}">
    <!-- Favicon -->
    <link href="{{ asset('assets/images/favicon.ico') }}" rel="shortcut icon" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">

    <!-- CSS Global Compulsory (Do not remove)-->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap.min.css') }}" />

    <!-- Page CSS Implementing Plugins (Remove the plugin CSS here if site does not use that feature)-->
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl-carousel/owl.carousel.min.css') }}" />

    <!-- Template Style -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>

    <!--=================================
    Header -->
    <header class="header bg-dark">
        <nav class="navbar navbar-static-top navbar-expand-lg header-sticky">
            <div class="container">
                <button id="nav-icon4" type="button" class="navbar-toggler" data-toggle="collapse"
                    data-target=".navbar-collapse">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <a class="navbar-brand" href="{{ route('index') }}">
                    <img class="img-fluid" src="{{asset('images/logo.jpg')}}" alt="logo">
                </a>
                <div class="navbar-collapse collapse justify-content-start">
                    <ul class="nav navbar-nav">
                        <li class="nav-item dropdown @if(url()->current() == route('index')){{'active'}}@endif">
                            <a class="nav-link" href="{{ route('index') }}" id="navbarDropdown" role="button"><i
                                    class="fas fa-home" style="font-size: 15px; margin-right: 5px"></i> Trang chủ</a>
                        </li>
                        <li class="nav-item dropdown @if(strpos(url()->current(), 'tim-atm') != false){{'active'}}@endif">
                            <a class="nav-link dropdown-toggle" href="{{ route('atm') }}">
                                Tìm ATM
                            </a>
                        </li>
                        <li class="nav-item dropdown  @if(strpos(url()->current(), 'lai-suat') != false){{'active'}}@endif">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Lãi suất <i class="fas fa-chevron-down fa-xs"></i>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($viewShare['bank'] as $bankItem)
                                    @if (!in_array($bankItem->id, [3, 6, 8]))
                                        <li>
                                            <a class="dropdown-item"
                                            href="{{ route('interest-rate', ['slug' => str_slug($bankItem->name_en), 'id' => $bankItem->id]) }}">
                                                {{$bankItem->name_en}}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item dropdown  @if(strpos(url()->current(), 'ty-gia') != false){{'active'}}@endif">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" href="#" aria-expanded="false">
                                Tỷ giá <i class="fas fa-chevron-down fa-xs"></i>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($viewShare['bank'] as $bankItem)
                                    @if (!in_array($bankItem->id, [7, 10]))
                                        <li>
                                            <a class="dropdown-item"
                                            href="{{ route('exchange-rate', ['slug' => str_slug($bankItem->name_en), 'id' => $bankItem->id]) }}">
                                                {{$bankItem->name_en}}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item dropdown  @if(strpos(url()->current(), 'chi-nhanh-') != false){{'active'}}@endif">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Chi nhánh <i class="fas fa-chevron-down fa-xs"></i>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($viewShare['bank'] as $bankItem)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('bank', ['slug' => $bankItem->slug]) }}">
                                        {{$bankItem->name_en}}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li id="bank-intro" class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Ngân hàng <i class="fas fa-chevron-down fa-xs"></i>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($viewShare['bank'] as $bankItem)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('bank-intro', ['slug' => str_slug($bankItem->name_en), 'id' => $bankItem->id]) }}">
                                        {{$bankItem->name_en}}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item dropdown  @if(strpos(url()->current(), 'swift-code') != false){{'active'}}@endif">
                            <a class="nav-link" href="{{ route('news-detail', ['slug' => $viewShare['swift_code']->slug, 'id' => $viewShare['swift_code']->id]) }}">
                                Swift Code
                            </a>
                        </li>
                        <li class="nav-item dropdown  @if(strpos(url()->current(), 'tin-tuc') != false && strpos(url()->current(), 'swift-code') == false){{'active'}}@endif">
                            <a class="nav-link" href="{{ route('news') }}">
                                Tin tức
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!--=================================
Header -->
