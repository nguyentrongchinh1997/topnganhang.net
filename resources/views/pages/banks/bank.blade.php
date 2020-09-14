@extends('layouts.index')

@section('title', 'Tổng hợp chi nhánh, PGD ngân hàng ' . $bank->name_en . ' tại Việt Nam | Chi nhánh ngân hàng ' . $bank->name_en . ' tại Việt Nam')

@section('description', 'Danh sách chi nhánh, PGD ngân hàng ' . $bank->name_en . ' tại Việt Nam. Tìm kiếm chi nhánh ngân hàng ' . $bank->name_en)

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
                        <li class="breadcrumb-item active"></i>
                            <a href="{{ url()->current() }}">
                                <span>Chi nhánh ngân hàng {{ $bank->name_en }}</span>
                            </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    @include('pages.includes.form_search_branch')
    <br><br>
    <section class="space-ptb">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 style="margin-bottom: 20px" class="text-left">Chi nhánh ngân hàng {{ $bank->name_en }} tại các tỉnh thành</h2>
                        </div>
                    </div>
                    @foreach ($provinces as $provinceItem)
                        <a href="{{ route('province-bank', ['bank_name' => $bank->slug, 'province' => $provinceItem->slug]) }}">
                            <div class="row" style="margin: 0px">
                                <div class="job-list border" style="width: 100%">
                                    <div class="job-list-details">
                                        <div class="job-list-info">
                                            <div class="job-list-title">
                                                <h2 class="mb-0">
                                                    {{ $provinceItem->name }}
                                                </h2>
                                            </div>
                                            <div class="job-list-option">
                                                <ul class="list-unstyled">
                                                    <li style="color: #333">
                                                        Ngân hàng {{ $bank->name_en }} có
                                                        {{ $provinceItem->branch->count() }} phòng giao dịch tại
                                                        {{ $provinceItem->name }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                        </a>
                        {{-- <div class="widget pb-3">
                            <a
                                href="{{ route('province-bank', ['bank_name' => $bank->slug, 'province' => $provinceItem->slug]) }}">
                                <div class="docs-content">
                                    <div class="docs-text">
                                        {{ $provinceItem->name }}
                                    </div>
                                    <div class="docs-icon text-right">
                                        {{ $provinceItem->branch->count() }}
                                    </div>
                                </div>
                            </a>
                        </div> --}}
                    @endforeach
                    <div class="row">
                        <div class="col-12 section-title-02">
                            <h2 class="text-left">Ngân hàng {{ $bank->name_en }}</h2>
                            <p>
                                {!! $bank->content !!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        @include('pages.includes.bank_sidebar')
                        @include('pages.includes.latest_news')
                        
                    </div>
                    {{-- <h4>
                        Tỷ giá ngân hàng
                    </h4><br>
                    @foreach ($viewShare['bank'] as $bankItem)
                        <div class="widget pb-3">
                            <a title="Tỷ giá ngân hàng {{ $bankItem->name_en }}"
                                href="{{ route('exchange-rate', ['slug' => str_slug($bankItem->name_en), 'id' => $bankItem->id]) }}">
                                <div class="docs-content">
                                    <div class="docs-text">
                                        » {{ $bankItem->name_en }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach --}}
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
	<script src="{{ asset('assets/js/get_district.js') }}"></script>
	<script>
		function branchSearch()
		{
			bank = $('#bank').val();
			province = $('#province').val();
			district = $('#district').val();
			
			if (bank == -1) {
				alert('Bạn muốn tìm chi nhánh ngân hàng nào?');

				return false;	
			} else if (province == -1) {
				alert('Bạn muốn tìm chi nhánh của tỉnh / thành phố nào?');

				return false;
			}

			return true;
		}
	</script>
@endsection
