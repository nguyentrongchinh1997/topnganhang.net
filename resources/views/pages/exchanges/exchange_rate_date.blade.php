@extends('layouts.index')

@section('title',
    'Tỷ giá ngân hàng ' .
    $bank->name_en .
    ' ngày ' .
    date('d/m/Y', strtotime($date)) .
    ' |
    Tỷ giá ngân hàng ' .
    $bank->name_en)

@section('description', 'Tra cứu tỷ giá ngân hàng ' . $bank->name_en . ' ngày ' . date('d/m/Y',
    strtotime($date)) . ', tỷ giá ngân hàng ' . $bank->name_en . ' ngày ' . date('d/m/Y',
    strtotime($date)))

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
                <div class="col-lg-8">
                    <h2>
                        Tỷ giá ngân hàng {{ $bank->name_en }} - Ngân hàng {{ $bank->name_vi }}
                    </h2>
                    <br>
                    @if (!@empty($exchangeRate))
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
                                    <button type="submit" id="exchange-submit" class="btn btn-primary mt-3">Tìm
                                        kiếm</button>
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
                    @else
                        <div class="alert alert-danger">
                            Tỷ giá ngân hàng {{ $bank->name_en }} cho ngày {{ date('d/m/Y', strtotime($date)) }} chưa được
                            cập nhật, bạn vui lòng truy cập lại sau.
                        </div>
                    @endif
                    <h3>
                        Giới thiệu
                    </h3>
                    {!! $bank->content !!}
                    <h2>
                        Chi nhánh, PGD ngân hàng {{$bank->name_en}}
                    </h2><br>
                    <div class="row">
                        @foreach($branchRandom as $branchItem)
                            <div class="col-lg-6" style="margin-bottom: 20px">
                                <div class="job-list border" style="width: 100%">
                                    <div class="job-list-details">
                                        <a href="{{route('bank-branch-detail', ['bank_name' => $branchItem->bank->name_en, 'province' => $branchItem->district->province->slug, 'branch' => str_slug($branchItem->name), 'id' => $branchItem->id])}}">
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
                </div>
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="widget">
                            <div class="widget-title">
                                <h2>Tin mới</h2>
                            </div>
                            @foreach ($latestNews as $newsItem)
                                <div class="row d-flex mb-3 align-items-start">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-12" style="margin-bottom: 20px">
                                        <img class="img-fluid" src='{{ asset("upload/thumbnails/$newsItem->image") }}'
                                            alt="">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-12">
                                        <a
                                            href="{{ route('news-detail', ['slug' => $newsItem->slug, 'id' => $newsItem->id]) }}">{{ $newsItem->title }}</a>
                                        <a class="d-block font-sm mt-1 text-light" href="#">
                                            {{ getWeekday($newsItem->created_at) }}
                                        </a>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
