@extends('layouts.index')

@section('title', 'Tin tức ngân hàng | Tin tức trong ngày')

@section('description', 'Tin tức tài chính ngân hàng, tổng hợp tin tức trong ngày')

@section('content')
    <section>
        <div class="container">
            <div class="row header-inner">
                <div class="col-lg-12">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}"> <i class="fas fa-home"></i>Trang chủ
                            </a>
                        </li>
                        <li>
                            <span class="space">/</span>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url()->current() }}">
                                <span>Tin tức</span>
                            </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="space-ptb">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @foreach ($news as $newsItem)
                        <div class="blog-post">
                            <div class="blog-post-image">
                                <a href="{{ route('news-detail', ['slug' => $newsItem->slug, 'id' => $newsItem->id]) }}">
                                    <img class="img-fluid" src='{{ asset("upload/og_images/$newsItem->image") }}'
                                        alt="{{ $newsItem->title }}">
                                </a>
                            </div>
                            <div class="blog-post-content">
                                <div class="blog-post-details">
                                    <div class="blog-post-title">
                                        <h2 title="{{ $newsItem->title }}">
                                            <a
                                                href="{{ route('news-detail', ['slug' => $newsItem->slug, 'id' => $newsItem->id]) }}">{{ $newsItem->title }}</a>
                                        </h2>
                                    </div>
                                    <div class="blog-post-time" style="margin: 0px">
                                        <a href="#">
                                            <i class="far fa-clock"></i>
                                            {{ getWeekday($newsItem->created_at) }}
                                            <span style="margin: 0px 10px">|</span>
                                            <i class="fas fa-eye"></i>
                                            {{ $newsItem->view }} lượt xem
                                        </a>
                                    </div>
                                    <div class="blog-post-description">
                                        <p class="mb-0">
                                            {!! strip_tags($newsItem->description) !!}
                                        </p>
                                    </div>
                                </div>
                                <div class="blog-post-footer">
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            {{ $news->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="blog-sidebar">
                        <div class="widget">
                            <div class="widget-title">
                                <h2>PGD ngân hàng</h2>
                            </div>
                            <div class="social">
                                <ul class="list-unstyled">
                                    @foreach ($viewShare['bank'] as $bankItem)
                                        <li>
                                            <a title="Chi nhánh ngân hàng {{ $bankItem->name_en }}"
                                                href="{{ route('bank', ['slug' => $bankItem->slug]) }}"> » {{$bankItem->name_en}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="widget">
                            <div class="widget-title">
                                <h2>Ngân hàng {{$bank->name_en}}</h2>
                            </div>
                            <div class="social">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="{{route('exchange-rate', ['bank' => str_slug($bank->name_en), 'id' => $bank->id])}}"> » Xem tỷ giá</a>
                                    </li>
                                    <li>
                                        <a href="{{route('interest-rate', ['bank' => str_slug($bank->name_en), 'id' => $bank->id])}}"> » Xem lãi suất</a>
                                    </li>
                                    <li>
                                        <a href="{{route('bank', ['bank' => str_slug($bank->slug)])}}"> » Xem chi nhánh</a>
                                    </li>
                                    <li>
                                        <a href="{{route('bank-atm', ['bank' => str_slug($bank->name_en), 'id' => $bank->id])}}"> » Tra cứu ATM</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('news-detail', ['slug' => $viewShare['swift_code']->slug, 'id' => $viewShare['swift_code']->id]) }}"> » Mã Swift Code</a>
                                    </li>
                                    <li>
                                        <a href="{{route('bank-intro', ['bank' => str_slug($bank->name_en), 'id' => $bank->id])}}"> » Giới thiệu</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=================================
                  blog -->
@endsection
