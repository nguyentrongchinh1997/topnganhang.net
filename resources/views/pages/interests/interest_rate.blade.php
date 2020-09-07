@extends('layouts.index')

@section('title', 'Lãi suất ngân hàng ' . $interestRate->bank->name_en . ' | Tra cứu lãi suất ngân hàng ' .
    $interestRate->bank->name_en)

@section('description', 'Lãi suất ngân hàng ' . $interestRate->bank->name_en . ', lãi suất cho vay của ngân hàng ' .
    $interestRate->bank->name_en . ', lãi suất gửi tiền tiết kiệm ngân hàng ' . $interestRate->bank->name_en)

@section('content')
    <section>
        <div class="container">
            <div class="row header-inner">
                <div class="col-lg-12">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}"> <i class="fas fa-home"></i>Trang chủ
                            </a></li>
                        <li>
                            <span class="space">/</span>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url()->current() }}">
                                <span>Lãi suất ngân hàng {{ $interestRate->bank->name_en }}</span>
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
                <div class="col-lg-9">
                    <h2>Lãi suất ngân hàng {{ $interestRate->bank->name_en }} - Ngân hàng {{ $interestRate->bank->name_vi }}
                    </h2>
                    <br>
                    <div class="content">
                        {!! $interestRate->content !!}
                    </div>
                    <style>
                        .content h3 {
                            font-size: 20px;
                        }

                        .content strong {
                            font-weight: bold;
                        }

                        .content img {
                            display: block;
                            margin-left: auto;
                            margin-right: auto;
                            max-width: 100%;
                        }

                    </style>
                </div>
                <div class="col-lg-3">
                    <div class="blog-sidebar">
                        @include('pages.includes.latest_news')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
