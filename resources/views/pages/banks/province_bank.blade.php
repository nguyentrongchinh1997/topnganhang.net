@extends('layouts.index')

@section('title', 'Chi nhánh, PGD ngân hàng ' . $bank->name_en . ' tại ' . $province->name)

@section('description', 'Chi nhánh, PGD ngân hàng ' . $bank->name_en . ' tại ' . $province->name . '. Tìm kiếm chi nhánh, PGD ngân hàng ' . $bank->name_en . ' tại ' . $province->name . '. Tổng hợp ' . 'Chi nhánh, PGD ngân hàng ' . $bank->name_en . ' tại ' . $province->name)

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
					<li class="breadcrumb-item active"><span>{{$bank->name_en}}</span></li>
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
				<h2 style="margin-bottom: 20px" title="Phòng giao dịch ngân hàng Vietcombank ở Hà Nội">PGD {{$bank->name_en}} tại {{$province->name}}</h2>
				@foreach($branchs as $branchItem)
					<div class="row" style="margin: 0px">
						<div class="job-list border" style="width: 100%">
							<div class="job-list-details">
								<a href="{{route('bank-branch-detail', ['bank_name' => str_slug($bank->name_en), 'province' => $province->slug, 'branch' => str_slug($branchItem->name), 'id' => $branchItem->id])}}">
									<div class="job-list-info">
										<div class="job-list-title">
											<h2 title="{{$branchItem->name}} - Ngân hàng {{$bank->name_en}}" class="mb-0">{{$branchItem->name}}</h2>
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
					<br>
				@endforeach
				{{$branchs->links()}}
			</div>
			<div class="col-lg-4 blog-sidebar">
				<div class="widget">
					<div class="widget-title">
						<h2>PGD quận / huyện</h2>
					</div>
					<div class="social">
						<ul class="list-unstyled">
							@foreach($province->district as $districtItem)
								@if($districtItem->branch->where('bank_id', $bank->id)->count() > 0)
									<li>
										<a href="{{route('district-bank', ['bank_name' => $bank->slug, 'province' => $districtItem->province->slug, 'district' => $districtItem->slug])}}"> » {{$districtItem->name}}</a>
										<a class="follow ml-auto" href="#">{{$districtItem->branch->where('bank_id', $bank->id)->count()}}</a>
									</li>
								@endif
							@endforeach
						</ul>
					</div>
				</div>
				@include('pages.includes.latest_news')
				{{-- <h3> Quận/Huyện</h3>
				<br>
				<div class="category-style-02">
					@foreach($province->district as $districtItem)
						@if($districtItem->branch->where('bank_id', $bank->id)->count() > 0)
						<div class="widget pb-3">
							<a href="{{route('district-bank', ['bank_name' => $bank->slug, 'province' => $districtItem->province->slug, 'district' => $districtItem->slug])}}">
								<div class="docs-content">
									<div class="docs-text">
										{{$districtItem->name}}
									</div>
									<div class="docs-icon text-right">
										{{$districtItem->branch->where('bank_id', $bank->id)->count()}}
									</div>
								</div>
							</a>
						</div>
						@endif
					@endforeach
				</div> --}}
			</div>
		</div>
	</div>
</section>
@stop

@section('js')
<script src="{{asset('assets/js/branch_search.js')}}"></script>
<script src="{{asset('assets/js/get_district.js')}}"></script>
@endsection