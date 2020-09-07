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
			<div class="col-lg-9">
                <h2>
                    Ngân hàng {{$bank->name_en}} - Ngân hàng {{$bank->name_vi}}
                </h2>
                {!!$bank->content!!}
            </div>
            <div class="col-lg-3">
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
