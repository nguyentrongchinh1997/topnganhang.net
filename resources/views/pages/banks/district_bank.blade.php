@extends('layouts.index')

@section('title', 'Chi nhánh, PGD ngân hàng ' . $bank->name_en . ' tại ' . $district->name . ' - ' . $province->name . ' | Chi nhánh ngân hàng ' . $bank->name_en . ' tại ' . $district->name . ' - ' . $province->name)

@section('description', 'Chi nhánh, PGD ngân hàng ' . $bank->name_en . ' tại ' . $district->name . ' - ' . $province->name . '. Tìm kiếm chi nhánh, PGD ngân hàng ' . $bank->name_en . ' tại ' . $district->name . ' - ' . $province->name)

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
				<h2 style="margin-bottom: 20px">PGD {{$bank->name_en}} tại {{$district->name}} - {{$district->province->name}}</h2>
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
				<p>
					{!!$string!!}
				</p>
			</div>
			<div class="col-lg-4">
				<div class="blog-sidebar">
					@include('pages.includes.latest_news')
				</div>
			</div>
		</div>
	</div>
</section>
@stop

@section('js')
<script src="{{asset('assets/js/get_district.js')}}"></script>
<script src="{{asset('assets/js/branch_search.js')}}"></script>
@endsection