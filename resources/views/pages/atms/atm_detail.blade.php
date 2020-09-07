@extends('layouts.index')

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
							<span>
								Điểm đặt cây ATM ngân hàng 
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
			<div class="col-lg-9">
                <h3>
                    Cây ATM
                </h3>
            </div>
            <div class="col-lg-3">
				<div class="blog-sidebar">
					@include('pages.includes.latest_news')
				</div>
            </div>
        </div>
    </div>
</section>
@endsection