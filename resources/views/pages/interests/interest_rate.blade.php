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
                <div class="col-lg-8">
                    <h2>Lãi suất ngân hàng {{ $interestRate->bank->name_en }} - Ngân hàng {{ $interestRate->bank->name_vi }}
                    </h2>
                    <br>
                    <div class="content">
                        {!! $interestRate->content !!}
                    </div>
                    <h2>
                        Chi nhánh, PGD ngân hàng {{$bank->name_en}}
                    </h2><br>
                    <div class="row">
                        @foreach($branchRandom as $branchItem)
                            <div class="col-lg-6" style="margin-bottom: 20px">
                                <div class="job-list border" style="width: 100%">
                                    <div class="job-list-details">
                                        <a href="{{route('bank-branch-detail', ['bank_name' => str_slug($branchItem->bank->name_en), 'province' => $branchItem->district->province->slug, 'branch' => str_slug($branchItem->name), 'id' => $branchItem->id])}}">
                                            <div class="job-list-info">
                                                <div class="job-list-title">
                                                    <h5 class="mb-0">{{$branchItem->name}}</h5>
                                                </div>
                                                <div class="job-list-option">
                                                    <ul class="list-unstyled">
                                                        <li><i class="fas fa-map-marker-alt pr-1"></i>{{$branchItem->address}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        @include('pages.includes.bank_tool')
                        @include('pages.includes.bank_sidebar')
                        @include('pages.includes.latest_news')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
