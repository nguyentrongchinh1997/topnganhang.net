@extends('layouts.index')

@section('title', 'Danh sách điểm đặt cây ATM ngân hàng ' . $bank->name_en . ' tại các tỉnh thành | Điểm đặt ngân hàng '
    . $bank->name_en)

@section('description', 'Tìm kiếm điểm đặt ATM ngân hàng ' . $bank->name_en . ' tại các tỉnh, thành phố. Tìm kiếm điểm
    đặt ATM nhanh nhất, công cụ tìm kiếm điểm đặt ATM.')

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
                                <span>Điểm đặt cây ATM ngân hàng {{ $bank->name_en }}</span>
                            </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            @include('pages.includes.form_search_atm')
        </div>
    </section>
    <br><br>
    <section class="space-ptb">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <h3 title="Cây ATM {{ $bank->name_en }} các tỉnh thành">
                        Cây ATM {{ $bank->name_en }} các tỉnh thành
                    </h3>
                    <br>
                    <div class="row">
                        @foreach ($provinces as $provinceItem)
                            {{-- <div class="col-lg-6">
                                <a href="" class="bank-atm">
                                    <div>
                                        {{ $provinceItem->name }}
                                        ({{ $provinceItem->atm->where('bank_id', $bank->id)->count() }})
                                    </div>
                                </a>
                            </div> --}}
                            <div class="col-lg-6">
                                <div class="widget pb-3">
                                    <a
                                        href="{{ route('province-atm', ['bank' => str_slug($bank->name_en), 'province' => $provinceItem->slug, 'bank_id' => $bank->id, 'province_id' => $provinceItem->id]) }}">
                                        <div class="docs-content">
                                            <div class="docs-text">
                                                {{ $provinceItem->name }}
                                            </div>
                                            <div class="docs-icon text-right">
                                                {{ $provinceItem->atm->where('bank_id', $bank->id)->count() }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
