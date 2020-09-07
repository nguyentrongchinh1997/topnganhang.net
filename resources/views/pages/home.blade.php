@extends('layouts.index')

@section('title', 'Tổng hợp thông tin ngân hàng trên toàn quốc | Tim kiếm chi nhánh ngân hàng')

@section('description', 'Thông tin tất cả ngân hàng tại Việt Nam. Công cụ tìm kiếm chi nhánh ngân hàng, tìm kiếm điểm đặt cây ATM, xem tỷ giá ngân hàng, tin tức ngân hàng, tra cứu lãi suất ngân hàng')

@section('content')
<!--=================================
	Tìm kiếm chi nhánh ngân hàng -->
	<section class="position-relative">
		<div class="banner bg-holder bg-overlay-black-20 text-dark" style="background-image: url(assets/images/bg/banner-02.jpg);">
			<div class="container">
				<div class="row">
					<div class="col-xl-9 text-left">
						<h1 class="text-dark">
							Tìm kiếm chi nhánh ngân hàng Việt Nam
						</h1>
						<div class="job-search-field">
							<div class="job-search-item">
								<form class="form row" method="post" action="{{route('search')}}">
									@csrf
									<div class="form-group col-md-4 select-border">
										<label>Ngân hàng</label>
										<select name="bank" class="form-control basic-select">
											@foreach($banks as $bankItem)
												<option value="{{$bankItem->id}}">
													{{$bankItem->name_en}}
												</option>
											@endforeach
										</select>
									</div>
									<div class="form-group col-md-4 select-border">
										<label>Tỉnh/TP</label>
										<select name="province" id="province" class="form-control basic-select">
											@foreach($provinces as $provinceItem)
												<option value="{{$provinceItem->id}}">{{$provinceItem->name}}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group col-md-4 select-border">
										<label>Quận/Huyện</label>
										<select name="district" id="district" class="form-control basic-select">
											@foreach($districtHcm as $districtHcmItem)
												<option value="{{$districtHcmItem->id}}">{{$districtHcmItem->name}}</option>
											@endforeach
										</select>
									</div>
									
									<div class="col-lg-4 col-sm-12">
										<div class="form-group form-action">
											<button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-search"></i> Tìm kiếm</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<svg  class="banner-shape" xmlns="http://www.w3.org/2000/svg" width="100%" height="100" viewBox="0 0 1920 100">
			<path class="cls-1" fill="#ffffff" d="M0,80S480,0,960,0s960,80,960,80v20H0V80Z"/></svg>
		</section>
<!--=================================
	end -->

<!--=================================
	Browse-job -->
	<section class="space-ptb">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h3 class="mb-3" style="text-align: center">Tỷ giá ngân hàng</h3>
					<hr>
					<div class="justify-content-center flex-fill">
						<ul class="nav nav-tabs nav-tabs-02 justify-content-center d-flex mb-3 mb-md-0" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Vietcombank</a>
							</li>
							<li onClick="getExchange(2)" class="nav-item">
								<a class="nav-link" id="profile-tab" data-toggle="tab" href="#ty-gia" role="tab" aria-controls="profile" aria-selected="false">Vietinbank</a>
							</li>
							<li onClick="getExchange(5)" class="nav-item">
								<a class="nav-link" id="contact-tab" data-toggle="tab" href="#ty-gia" role="tab" aria-controls="contact" aria-selected="false">Agribank</a>
							</li>
							<li onClick="getExchange(9)" class="nav-item">
								<a class="nav-link" id="home-tab" data-toggle="tab" href="#ty-gia" role="tab" aria-controls="home" aria-selected="true">Techcombank</a>
							</li>
							<li onClick="getExchange(4)" class="nav-item">
								<a class="nav-link" id="profile-tab" data-toggle="tab" href="#ty-gia" role="tab" aria-controls="profile" aria-selected="false">BIDV</a>
							</li>
							<li onClick="getExchange(11)" class="nav-item">
								<a class="nav-link" id="contact-tab" data-toggle="tab" href="#ty-gia" role="tab" aria-controls="contact" aria-selected="false">Sacombank</a>
							</li>
							<li onClick="getExchange(8)" class="nav-item">
								<a class="nav-link" id="home-tab" data-toggle="tab" href="#ty-gia" role="tab" aria-controls="home" aria-selected="true">Maritime Bank</a>
							</li>
							<li onClick="getExchange(3)" class="nav-item">
								<a class="nav-link" id="profile-tab" data-toggle="tab" href="#ty-gia" role="tab" aria-controls="profile" aria-selected="false">ACB</a>
							</li>
							<li onClick="getExchange(6)" class="nav-item">
								<a class="nav-link" id="contact-tab" data-toggle="tab" href="#ty-gia" role="tab" aria-controls="contact" aria-selected="false">MBBank</a>
							</li>
						</ul>
					</div>
					<div class="tab-content">
						<div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
							<h4 style="margin: 30px 0px; text-align: center">
								Tỷ giá ngân hàng Vietcombank <br>
								Ngày: {{date('d/m/Y', strtotime($exchangeRate->date))}}
							</h4>
							<div class="row mt-4 mt-md-5 exchange-rate" style="margin: 10px 0px 0px 0px !important">
								{!!$exchangeRate->content!!}
							</div>
						</div>
						<div class="tab-pane fade" id="ty-gia" role="tabpanel" aria-labelledby="profile-tab">
							<h4 id="date" style="margin: 30px 0px; text-align: center">

							</h4>
							<div class="row mt-4 mt-md-5 exchange-rate" style="margin: 10px 0px 0px 0px !important">
								<div id="result" style="width: 100%"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<!--=================================
	Blog -->
	<section class="space-ptb">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-title-02">
						<h2>Tin Tức</h2>
					</div>
				</div>
			</div>
			<div class="row">
				@foreach($news as $newsItem)
					<div class="col-lg-4 mb-lg-0 mb-4 news-home">
						<div class="blog-post">
							<div class="blog-post-image">
								<a href="{{route('news-detail', ['slug' => $newsItem->slug, 'id' => $newsItem->id])}}">
								<img class="img-fluid" src='{{asset("upload/og_images/$newsItem->image")}}' alt="{{$newsItem->title}}">
								</a>
							</div>
							<div class="blog-post-content">
								<div class="blog-post-details">
									<div class="blog-post-title">
									<h5><a href="{{route('news-detail', ['slug' => $newsItem->slug, 'id' => $newsItem->id])}}">{{$newsItem->title}}</a></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 mb-lg-0 mb-4 news-home">
						<div class="blog-post">
							<div class="blog-post-image">
								<a href="{{route('news-detail', ['slug' => $newsItem->slug, 'id' => $newsItem->id])}}">
								<img class="img-fluid" src='{{asset("upload/og_images/$newsItem->image")}}' alt="{{$newsItem->title}}">
								</a>
							</div>
							<div class="blog-post-content">
								<div class="blog-post-details">
									<div class="blog-post-title">
									<h5><a href="{{route('news-detail', ['slug' => $newsItem->slug, 'id' => $newsItem->id])}}">{{$newsItem->title}}</a></h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>
<!--=================================
	Blog -->
@endsection

@section('js')
<script src="{{asset('assets/js/get_district.js')}}"></script>
<script>
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	function getExchange(bankId)
	{
		$.ajax({
				type:'POST',
				url:'{{route("get-exchange")}}',
				data:{bankId:bankId},
				success:function(data){
					$('#result').html(data.table);
					$('#date').html('Tỷ giá ngân hàng ' + data.bank_name + '<br>Ngày: ' + data.date);
				}
        });
	}
</script>
@endsection