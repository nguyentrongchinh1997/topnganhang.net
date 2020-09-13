@extends('layouts.index')

@section('title', 'Chi nhánh, PGD ngân hàng ' . $branch->bank->name_en . ' ' . $branch->district->name . ', ' .
    $branch->district->province->name . ' | ' . $branch->name . ' ngân hàng ' . $branch->bank->name_en . ' ' .
    $branch->district->name . ', ' . $branch->district->province->name)

@section('description', 'Chi nhánh ngân hàng ' . $branch->bank->name_en . ' ' . $branch->district->name . ', ' .
    $branch->district->province->name . '. ' . $branch->name . ' ngân hàng ' . $branch->bank->name_en . ' tại ' .
    $branch->district->name . ', ' . $branch->district->province->name . '. Địa chỉ: ' . $branch->address)

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
                            <a href="{{ route('bank', ['slug' => $branch->bank->slug]) }}">
                                Chi nhánh {{ $branch->bank->name_en }}
                            </a>
                        </li>
                        <li>
                            <span class="space">/</span>
                        </li>
                        <li class="breadcrumb-item active">
                            <a
                                href="{{ route('district-bank', ['bank_name' => str_slug($branch->bank->name_vi), 'province' => $branch->district->province->slug, 'district' => $branch->district->slug]) }}">
                                {{ $branch->district->name }}
                            </a>
                        </li>
                        <li>
                            <span class="space">/</span>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url()->current() }}">
                                {{ $branch->name }}
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
                        {{ $branch->name }} - Ngân hàng {{ $branch->bank->name_en }}
                    </h2>
                    <div class="general-info">
                        <h6>
                            Thông tin chung:
                        </h6>
                        <hr>
                        @if ($branch->other_info != '')
                            {!! $branch->other_info !!}
                        @else
                            <p>
                                <b>Địa chỉ: </b> {{ $branch->addeess }}
                            </p>
                        @endif
                        <br><br>
                        <center>
                            <a target="_blank"
                                href="http://maps.google.com/maps?q={{ $branch->address }}&spn=,&hl=visssssss">
                                <button class=" btn btn-primary"><i class="fas fa-map-marker-alt"></i> Xem bản đồ</button>
                            </a>
                            <a target="_blank"
                                href="http://maps.google.com/maps?q={{ $branch->address }}&spn=,&hl=visssssss">
                                <button class="btn btn-info mb-2" style='margin-bottom: 0px !important'><i class="fas fa-globe-asia"></i> Website</button>
                            </a>
                        </center>
                    </div>
                    <br><br>
                    <h2>
                        Chi nhánh, PGD cùng quận / huyện
                    </h2><br>
                    <div class="row">
                        @foreach ($districtSameBranchs as $branchItem)
                            <div class="col-lg-6" style="margin-bottom: 20px">
                                <div class="job-list border" style="width: 100%">
                                    <div class="job-list-details">
                                        <a
                                            href="{{ route('bank-branch-detail', ['bank_name' => str_slug($branchItem->bank->name_en), 'province' => $branchItem->district->province->slug, 'branch' => str_slug($branchItem->name), 'id' => $branchItem->id]) }}">
                                            <div class="job-list-info">
                                                <div class="job-list-title">
                                                    <h5 class="mb-0">{{ $branchItem->name }}</h5>
                                                </div>
                                                <div class="job-list-option">
                                                    <ul class="list-unstyled">
                                                        <li><i
                                                                class="fas fa-map-marker-alt pr-1"></i>{{ $branchItem->address }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <h2>
                        Chi nhánh, PGD tại các tỉnh khác
                    </h2><br>
                    <div class="row">
                        @foreach ($otherBranchs as $branchItem)
                            <div class="col-lg-6" style="margin-bottom: 20px">
                                <div class="job-list border" style="width: 100%">
                                    <div class="job-list-details">
                                        <a
                                            href="{{ route('bank-branch-detail', ['bank_name' => str_slug($branchItem->bank->name_en), 'province' => $branchItem->district->province->slug, 'branch' => str_slug($branchItem->name), 'id' => $branchItem->id]) }}">
                                            <div class="job-list-info">
                                                <div class="job-list-title">
                                                    <h5 class="mb-0">{{ $branchItem->name }}</h5>
                                                </div>
                                                <div class="job-list-option">
                                                    <ul class="list-unstyled">
                                                        <li><i
                                                                class="fas fa-map-marker-alt pr-1"></i>{{ $branchItem->address }}
                                                        </li>
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
                <div class="col-lg-4 blog-sidebar">
                    <div class="widget">
                        <div class="widget-title">
                            <h2>Xem thêm</h2>
                        </div>
                        <div class="social">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{route('exchange-rate', ['bank' => str_slug($branch->bank->name_en), 'id' => $branch->bank->id])}}"> » Xem tỷ giá</a>
                                </li>
                                <li>
                                    <a href="{{route('interest-rate', ['bank' => str_slug($branch->bank->name_en), 'id' => $branch->bank->id])}}"> » Xem lãi suất</a>
                                </li>
                                <li>
                                    <a href="{{route('bank', ['bank' => str_slug($branch->bank->slug)])}}"> » Xem chi nhánh</a>
                                </li>
                                <li>
                                    <a href="{{route('bank-atm', ['bank' => str_slug($branch->bank->name_en), 'id' => $branch->bank->id])}}"> » Tra cứu ATM</a>
                                </li>
                                <li>
                                    <a href="{{ route('news-detail', ['slug' => $viewShare['swift_code']->slug, 'id' => $viewShare['swift_code']->id]) }}"> » Mã Swift Code</a>
                                </li>
                                <li>
                                    <a href="{{route('bank-intro', ['bank' => str_slug($branch->bank->name_en), 'id' => $branch->bank->id])}}"> » Giới thiệu</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @include('pages.includes.latest_news')
                </div>
            </div>
        </div>
    </section>

@endsection
