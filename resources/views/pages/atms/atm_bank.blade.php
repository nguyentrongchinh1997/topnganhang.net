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
                    @if(count($provinces) > 0)
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
                    @endif
                    @if(count($atms) > 0)
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
                    @endif
                    @if(count($atms) == 0 && count($provinces) == 0)
                        <div class="alert alert-danger">
                            Điểm đặt cây ATM ngân hàng {{$bank->name_en}} - {{$bank->name_vi}} đang được cập nhật
                        </div>
                    @endif
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

    
