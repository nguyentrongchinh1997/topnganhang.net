@extends('layouts.index')

@section('title', $branch->name . ' - Ngân hàng ' . $branch->bank->name_en)

@section('description', strip_tags($branch->other_info))

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
                        <a href="{{route('bank', ['slug' => $branch->bank->slug])}}">
                            Chi nhánh {{$branch->bank->name_en}}
                        </a>
                    </li>
                    <li>
                        <span class="space">/</span>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="{{route('district-bank', ['bank_name' => str_slug($branch->bank->name_vi), 'province' => $branch->district->province->slug, 'district' => $branch->district->slug])}}">
                            {{$branch->district->name}}
                        </a>
                    </li>
                    <li>
                        <span class="space">/</span>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="{{url()->current()}}">
                            {{$branch->name}}
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
                <h2>
                    {{$branch->name}} - Ngân hàng {{$branch->bank->name_en}}
                </h2>
                <h6>
                    Thông tin chung: 
                </h6>
                @if($branch->other_info != '')
                    {!!$branch->other_info!!}
                @else
                    <p>
                        Đang cập nhật...
                    </p>
                @endif
                <a target="_blank" href="http://maps.google.com/maps?q={{$branch->address}}&spn=,&hl=visssssss">
                    <button class="map btn btn-primary"><i class="fas fa-map-marker-alt"></i> Xem bản đồ</button>
                </a>
                <br><br>
                <h2>
                    Chi nhánh, PGD cùng quận / huyện
                </h2><br>
                <div class="row">
                    @foreach($districtSameBranchs as $branchItem)
                        <div class="col-lg-6" style="margin-bottom: 20px">
                            <div class="job-list border" style="width: 100%">
                                <div class="job-list-details">
                                    <a href="{{route('bank-branch-detail', ['bank_name' => str_slug($branchItem->bank->name_en), 'province' => $branchItem->district->province->slug, 'branch' => str_slug($branchItem->name), 'id' => $branchItem->id])}}">
                                        <div class="job-list-info">
                                            <div class="job-list-title">
                                                <h5 class="mb-0">{{$branchItem->name}}</h5>
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
                    @endforeach
                </div>
                <h2>
                    Chi nhánh, PGD tại các tỉnh khác
                </h2><br>
                <div class="row">
                    @foreach($otherBranchs as $branchItem)
                        <div class="col-lg-6" style="margin-bottom: 20px">
                            <div class="job-list border" style="width: 100%">
                                <div class="job-list-details">
                                    <a href="{{route('bank-branch-detail', ['bank_name' => str_slug($branchItem->bank->name_en), 'province' => $branchItem->district->province->slug, 'branch' => str_slug($branchItem->name), 'id' => $branchItem->id])}}">
                                        <div class="job-list-info">
                                            <div class="job-list-title">
                                                <h5 class="mb-0">{{$branchItem->name}}</h5>
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
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4">
                @include('pages.includes.latest_news')
            </div>
        </div>
    </div>
</section>

@endsection