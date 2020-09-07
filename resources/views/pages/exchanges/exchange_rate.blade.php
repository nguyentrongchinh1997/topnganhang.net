@extends('layouts.index')

@section('title', 'Tỷ giá ngân hàng ' . $bank->name_en . ' hôm nay | Tỷ giá ngân hàng ' . $bank->name_en)

@section('description', 'Tra cứu tỷ giá ngân hàng ' . $bank->name_en . ', tỷ giá ngân hàng ' . $bank->name_en . 'hôm
    nay')

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
                                <span>Tỷ giá ngân hàng {{ $bank->name_en }}</span>
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
                    <h2>
                        Tỷ giá ngân hàng {{ $bank->name_en }} - Ngân hàng {{ $bank->name_vi }}
                    </h2>
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                            <p style="margin: 17px 0px 0px">
                                Cập nhật ngày {{ date('d/m/Y', strtotime($exchangeRate->date)) }}
                            </p>
                        </div>
                        <div class="col-lg-6">
                            <form style="margin-bottom: 10px; float: right"
                                action="{{ route('exchange-rate-search', ['id' => $bank->id]) }}" method="post">
                                @csrf
                                <input id="form-exchange" value="{{ $exchangeRate->date }}" name="date" type="date">
                                <button type="submit" id="exchange-submit" class="btn btn-primary mt-3">Tìm kiếm</button>
                            </form>
                        </div>
                    </div>
                    <div class="exchange-rate">
                        {!! $exchangeRate->content !!}
                    </div>
                    <p>
                        Tỷ giá ngân hàng {{ $bank->name_en }}, tỷ giá hôm này, tỷ giá ngày
                        {{ date('d/m/Y', strtotime($exchangeRate->date)) }}, tỷ giá đô la, tỷ giá yên nhật, tỷ giá trung
                        quốc,...
                    </p>
                    <h3>
                        Giới thiệu
                    </h3>
                    {!!$exchangeRate->bank->content!!}
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
