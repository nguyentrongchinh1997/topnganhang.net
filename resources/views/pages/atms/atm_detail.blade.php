@extends('layouts.index')

@section('title', 'Cây ATM ' . $atm->district->name . ', ' . $atm->province->name . ' | Cây ATM ' . $atm->name . ' ngân
    hàng ' . $atm->bank->name_en . ' tại ' . $atm->province->name)

@section('description', 'Cây ATM ' . $atm->district->name . ', ' . $atm->province->name . '. Cây ATM ' . $atm->name . ' ngân
hàng ' . $atm->bank->name_en . ' tại ' . $atm->district->name . ', ' . $atm->province->name .
    '. Địa chỉ: ' . $atm->address)

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
                            <a
                                href="{{ route('bank-atm', ['bank_name' => str_slug($atm->bank->name_en), 'id' => $atm->bank_id]) }}">
                                <span>
                                    ATM {{ $atm->bank->name_en }}
                                </span>
                            </a>
                        </li>
                        <li>
                            <span class="space">/</span>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url()->current() }}">
                                <span>
                                    Cây ATM {{ $atm->name }}
                                </span>
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
                    <h2 style="margin-bottom: 20px">
                        Cây ATM {{ $atm->name }} tại {{ $atm->province->name }}
                    </h2>
                    <div class="general-info">
                        <h6>Thông tin chung</h6>
                        <hr>
                        @if ($atm->other_info != '')
                            {!! $atm->other_info !!}
                        @else
                            <p>
                                <b>Địa chỉ: </b> {{ $atm->address }}
                            </p>
                        @endif
                        <br><br>
                        <center>
                            <a rel="nofollow" target="_blank" href="http://maps.google.com/maps?q={{ $atm->address }}&spn=,&hl=visssssss">
                                <button class="btn btn-primary"><i class="fas fa-map-marker-alt"></i> Xem bản đồ</button>
                            </a>
                            <a target="_blank" rel="nofollow" href="{{ $atm->bank->web }}">
                                <button class="btn btn-info mb-2" style='margin-bottom: 0px !important'><i
                                        class="fas fa-globe-asia"></i> Website</button>
                            </a>
                        </center>
                    </div>
                    <br>
                    <p>
                        Cây ATM {{ $atm->name }} tại {{ $atm->province->name }} - Ngân hàng {{ $atm->bank->name_en }}
                    </p>
                    <br><br>
                    <h2>
                        Điểm đặt cây ATM tại {{ $atm->province->name }}
                    </h2>
                    <br>
                    <div class="row">
                        @foreach ($otherAtm as $atmItem)
                            <div class="col-lg-6 atm-district">
                                <div class="job-list border" style="width: 100%">
                                    <a
                                        href="{{ route('atm-detail', ['bank_name' => str_slug($atmItem->bank->name_en), 'address' => $atmItem->slug, 'id' => $atmItem->id]) }}">
                                        <div class="job-list-details">
                                            <div class="job-list-info">
                                                <div class="job-list-option">
                                                    <ul class="list-unstyled">
                                                        <li><i class="fas fa-map-marker-alt pr-1"></i>
                                                            {{ $atmItem->address }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <br>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="widget">
                            <div class="widget-title">
                                <h2>Xem thêm</h2>
                            </div>
                            <div class="social">
                                <ul class="list-unstyled">
                                    <li>
                                        <a
                                            href="{{ route('exchange-rate', ['bank' => str_slug($atm->bank->name_en), 'id' => $atm->bank->id]) }}">
                                            » Xem tỷ giá</a>
                                    </li>
                                    <li>
                                        <a
                                            href="{{ route('interest-rate', ['bank' => str_slug($atm->bank->name_en), 'id' => $atm->bank->id]) }}">
                                            » Xem lãi suất</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('bank', ['bank' => str_slug($atm->bank->slug)]) }}"> » Xem chi
                                            nhánh</a>
                                    </li>
                                    <li>
                                        <a
                                            href="{{ route('bank-atm', ['bank' => str_slug($atm->bank->name_en), 'id' => $atm->bank->id]) }}">
                                            » Tra cứu ATM</a>
                                    </li>
                                    <li>
                                        <a
                                            href="{{ route('news-detail', ['slug' => $viewShare['swift_code']->slug, 'id' => $viewShare['swift_code']->id]) }}">
                                            » Mã Swift Code</a>
                                    </li>
                                    <li>
                                        <a
                                            href="{{ route('bank-intro', ['bank' => str_slug($atm->bank->name_en), 'id' => $atm->bank->id]) }}">
                                            » Giới thiệu</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @include('pages.includes.latest_news')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
