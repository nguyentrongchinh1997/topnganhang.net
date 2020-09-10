@extends('layouts.index')

@section('title', 'Thông tin ngân hàng ' . $bank->name_en . ' - Ngân hàng ' . $bank->name_vi)

@section('description', strip_tags(html_entity_decode($bank->description)))

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
                        <a href="{{url()->current()}}">
                            <span>Ngân hàng {{$bank->name_en}}</span>
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
                    Ngân hàng {{$bank->name_en}} - Ngân hàng {{$bank->name_vi}}
                </h2>
                {!!$bank->content!!}
                <h2>
                    Chi nhánh, PGD ngân hàng {{$bank->name_en}}
                </h2><br>
                <div class="row">
                    @foreach($branchRandom as $branchItem)
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

@section('js')
<script>
    $('#bank-intro').addClass('active');
</script>
@endsection
