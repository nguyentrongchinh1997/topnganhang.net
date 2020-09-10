@extends('layouts.index')

@section('title', $news->title)

@section('description', strip_tags(html_entity_decode($news->description)))

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
                            <a href="{{route('news')}}">
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
                    <div class="blog-detail">
                        <div class="blog-post">
                            <div class="blog-post-title">
                                <h2>{{ $news->title }}</h2>
                            </div>
                            <div class="blog-post-footer border-0 justify-content-start">
                                <div class="blog-post-time">
                                    <a href="#"> <i class="far fa-clock"></i>{{ getWeekday($news->created_at) }}</a>
                                </div>
                                <div class="blog-post-comment">
                                    <a href="#"> <i class="fas fa-eye"></i>{{ $news->view }} lượt xem</a>
                                </div>
                                @if(auth()->check() && auth()->user()->level > 0)
                                <div class="blog-post-comment">
                                    <a target="_blank" href="{{ route('admin.news.edit', ['id' => $news->id]) }}"> Sửa tin</a>
                                </div>
                                @endif
                            </div>
                            <div class="blog-post-content">
                                <div class="blog-post-description">
                                    <p class="mb-0">
                                        {!! $news->description !!}
                                    </p>
                                    <div class="blog-post-image">
                                        <img class="img-fluid" src='{{ asset("upload/og_images/$news->image") }}' alt="">
                                    </div>
                                    <br><br>
                                    <div id="news-detail">
                                        {!! $news->content !!}
                                    </div>
                                </div>
                                <br>
                                <div class="blog-sidebar">
                                    <b>Tags: </b><br><br>
                                    <div class="widget">
                                        <div class="popular-tag">
                                            <ul class="list-unstyled mb-0">
                                                @foreach (explode(',', $news->tags) as $tag)
                                                    <li><a href="#">{{ $tag }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="blog-sidebar">
                        <div class="widget">
                            <div class="widget-title">
                                <h2>Tin mới</h2>
                            </div>
                            @foreach ($latestNews as $newsItem)
                                <div class="news-item-sidebar row d-flex mb-3 align-items-start">
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-5">
                                        <a
                                            href="{{ route('news-detail', ['slug' => $newsItem->slug, 'id' => $newsItem->id]) }}">
                                            <img class="img-fluid" src='{{ asset("upload/thumbnails/$newsItem->image") }}'
                                                alt="{{ $newsItem->title }}">
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-7">
                                        <p>
                                            <a href="{{ route('news-detail', ['slug' => $newsItem->slug, 'id' => $newsItem->id]) }}">{{ $newsItem->title }}</a>
                                        </p>
                                        <a class="d-block font-sm mt-1 text-light" href="#">
                                            {{ getWeekday($newsItem->created_at) }}
                                        </a>
                                    </div>
                                </div><hr>
                            @endforeach
                        </div>
                        {{-- <div class="widget">
                            <div class="widget-title">
                                <h2>Tỷ giá ngân hàng</h2>
                            </div>
                            @foreach ($viewShare['bank'] as $bankItem)
                                @if (!in_array($bankItem->id, [7, 10]))
                                    <div class="pb-3">
                                        <a
                                            href="{{ route('exchange-rate', ['slug' => str_slug($bankItem->name_en), 'id' => $bankItem->id]) }}">
                                            <div class="docs-content">
                                                <div class="docs-text">
                                                    » {{ $bankItem->name_en }}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        #news-detail strong {
            font-weight: bold !important;
        }

        #news-detail img {
            max-width: 100%;
            height: auto !important;
        }

    </style>
@endsection
