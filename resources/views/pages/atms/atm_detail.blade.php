@extends('layouts.index')

@section('title', 'Cây ATM ' . $atm->name . ' ngân hàng ' . $atm->bank->name_en . ' | ' . 'Cây ATM ' . $atm->name . ' tại ' . $atm->province->name)

@section('description', 'Cây ATM ' . $atm->name . ' ngân hàng ' . $atm->bank->name_en . ' tại ' . $atm->province->name . '. Địa chỉ: ' . $atm->address)

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
					<a href="{{route('bank-atm', ['bank_name' => str_slug($atm->bank->name_en), 'id' => $atm->bank_id])}}">
							<span>
								ATM {{$atm->bank->name_en}}
							</span>
						</a>
					</li>
					<li>
                        <span class="space">/</span>
					</li>
					<li class="breadcrumb-item active">
						<a href="{{ url()->current() }}">
							<span>
								Cây ATM {{$atm->name}}
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
                <h3>
                    Cây ATM {{$atm->name}} tại {{$atm->province->name}} - Ngân hàng {{$atm->bank->name_en}}
				</h3>
				<h5>Thông tin chung</h5>
				@if($atm->other_info != '')
                    {!!$atm->other_info!!}
                @else
                    <p>
                        Đang cập nhật...
                    </p>
                @endif
                <a target="_blank" href="http://maps.google.com/maps?q={{$atm->address}}&spn=,&hl=visssssss">
                    <button class="map btn btn-primary"><i class="fas fa-map-marker-alt"></i> Xem bản đồ</button>
                </a>
                <br><br>
                <h2>
					Điểm đặt cây ATM tại {{$atm->province->name}}
				</h2>
				<br>
				<div class="row">
					@foreach ($otherAtm as $atmItem)
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
					@include('pages.includes.latest_news')
				</div>
            </div>
        </div>
    </div>
</section>
@endsection