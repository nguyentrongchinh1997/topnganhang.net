@extends('layouts.index')

@section('title', 'Điểm đặt cây ATM ngân hàng ' . $bank->name_en . ' tại các tỉnh thành | Điểm đặt ATM ngân hàng '
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
                <div class="col-lg-8">
                    <h2 style="margin-bottom: 20px" title="Cây ATM {{ $bank->name_en }} các tỉnh thành">
                        Cây ATM {{ $bank->name_en }} các tỉnh thành
                    </h2>
                    <div class="row">
                        @foreach ($provinces as $provinceItem)
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
                    <br>
                    <h3>
                        Cây ATM {{$bank->name_en}} tại các tỉnh thành
                    </h3><br>
                    <div class="row">
                        @foreach($atms as $atmItem)
                            <div class="col-lg-6 atm-district">
                                <div class="job-list border" style="width: 100%">
                                    <a href="{{ route('atm-detail', ['bank_name' => str_slug($bank->name_en), 'address' => $atmItem->slug, 'id' => $atmItem->id]) }}">
                                        <div class="job-list-details">
                                            <div class="job-list-info">
                                                <div class="job-list-option">
                                                    <ul class="list-unstyled">
                                                        <li><i class="fas fa-map-marker-alt pr-1"></i>
                                                            {{$atmItem->address}}
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
                        <div class="widget">
                            <div class="widget-title">
                                <h2>Tỷ giá ngân hàng</h2>
                            </div>
                            <div class="social">
                                <ul class="list-unstyled">
                                    @foreach ($viewShare['bank'] as $bankItem)
                                        @if (!in_array($bankItem->id, [7, 10]))
                                            <li>
                                                <a title="Tỷ giá ngân hàng {{ $bankItem->name_en }}"
                                                    href="{{ route('exchange-rate', ['slug' => str_slug($bankItem->name_en), 'id' => $bankItem->id]) }}"> » {{$bankItem->name_en}}</a>
                                            </li>
                                        @endif
                                    @endforeach
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

@section('js')
<script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function() {
            $('#province').change(function() {
                province_id = $(this).val();
                district_id = '';
                $.ajax({
                    type: 'POST',
                    url: '{{route("district")}}',
                    data: {
                        province_id: province_id,
                        district_id: district_id
                    },
                    success: function(data) {
                        $('#district').html(data);
                    }
                });
            })
        });
</script>
@endsection

    
