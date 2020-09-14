@extends('layouts.index')

@section('title', 'Tổng hợp điểm đặt cây ATM tại các tỉnh, thành phố tại Việt Nam')

@section('description', 'Tìm kiếm điểm đặt ATM tại các tỉnh, thành phố. Tìm kiếm điểm đặt ATM nhanh nhất, công cụ tìm kiếm điểm đặt ATM.')

@section('content')
<section>
	<div class="container">
		<div class="row header-inner">
			<div class="col-lg-12">
				<ol class="breadcrumb mb-0 p-0">
					<li class="breadcrumb-item"><a href="{{route('index')}}"> <i class="fas fa-home"></i>Trang chủ </a></li>
					<li>
                        <span class="space">/</span>
                    </li>
					<li class="breadcrumb-item active">
						<a href="{{ url()->current() }}">
							<span>Tìm ATM</span>
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
				<h4>Điểm đặt cây ATM các ngân hàng Việt Nam</h4>
				<br>
				@foreach($banks as $bankItem)
					<div class="row" style="margin: 0px">
						<div class="job-list border" style="width: 100%">
							<a href="{{route('bank-atm', ['slug' => str_slug($bankItem->name_en), 'id' => $bankItem->id])}}">
								<div class="job-list-details">
									<div class="job-list-info">
										<div class="job-list-title">
											<h5 class="mb-0" title="Điểm đặt ATM ngân hàng {{$bankItem->name_en}}">
												Ngân hàng {{$bankItem->name_en}} - Ngân hàng {{$bankItem->name_vi}}
											</h5>
										</div>
										<div class="job-list-option">
											<ul class="list-unstyled">
												<li><i class="fas fa-map-marker-alt pr-1"></i>
													{{number_format($bankItem->atm->count())}} điểm đặt
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
				<div class="row">
					@foreach ($atms as $atmItem)
						<div class="col-lg-6 atm-district">
							<div class="job-list border" style="width: 100%">
								<a href="{{ route('atm-detail', ['bank_name' => str_slug($atmItem->bank->name_en), 'address' => $atmItem->slug, 'id' => $atmItem->id]) }}">
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
	function check()
	{
		bank = $('#bank').val();

		if (bank == '') {
			alert('Bạn muốn tìm ATM của ngân hàng nào?');

			return false;
		}
		return true;
	}
	$(function(){
		$('#province').change(function(){
			province_id = $(this).val();
			district_id = '';
			$.ajax({
	           	type:'POST',
	           	url:'{{route("district")}}',
	           	data:{province_id:province_id,district_id:district_id},
	           	success:function(data){
	            	$('#district').html(data);
	           	}

	        });
		})
	});
</script>
@endsection