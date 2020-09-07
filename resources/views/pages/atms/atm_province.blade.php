@extends('layouts.index')

@section('title', 'Danh sách điểm đặt cây ATM ngân hàng ' . $bank->name_en . ' tại ' . $province->name . ' | Điểm đặt ngân hàng ' . $bank->name_en . ' tại ' . $province->name)

@section('description', 'Tổng hợp điểm đặt ATM ngân hàng ' . $bank->name_en . ' tại ' . $province->name . '. Tìm kiếm điểm đặt ATM nhanh nhất, công cụ tìm kiếm điểm đặt ATM.')

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
								Điểm đặt cây ATM ngân hàng {{ $bank->name_en }} tại {{$province->name}}
							</span>
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
			<div class="col-lg-9">
				<h3>
                    Cây ATM {{$bank->name_en}} tại {{$province->name}}
				</h3><br>
				<div class="row">
					@foreach($atms as $atmItem)
                        <div class="col-lg-6 atm-district">
                            <div class="job-list border" style="width: 100%">
                                <div class="job-list-details">
                                    <div class="job-list-info">
                                        <div class="job-list-option">
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-map-marker-alt pr-1"></i>
                                                    {{$atmItem->address}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    @endforeach
				</div>
				{{$atms->links()}}
                <h3 style="margin-top: 30px">
                    Cây ATM {{$bank->name_en}} tại các quận / huyện - {{$province->name}}
                </h3><br>
                <div class="row">
                    @foreach($districts as $districtsItem)
                        <div class="col-lg-6">
                            <div class="widget pb-3">
                                <a href="{{route('district-atm', ['bank' => str_slug($bank->name_en), 'district' => $districtsItem->slug, 'province' => $province->slug, 'bank_id' => $bank->id, 'province_id' => $province->id, 'district_id' => $districtsItem->id])}}">
                                    <div class="docs-content">
                                        <div class="docs-text">
                                            {{$districtsItem->name}}
                                        </div>
                                        <div class="docs-icon text-right">
                                            {{$districtsItem->atm->where('bank_id', $bank->id)->count()}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
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
	province_id = $('#province').val();
	$.ajax({
		type:'POST',
		url:'{{route("district-the-bank")}}',
		data:{province_id:province_id},
		success:function(data){
			$('#district').html(data);
		}

	});
	$(function(){
		$('#province').change(function(){
			province_id = $(this).val();
			district_id = '';
			$.ajax({
	           	type:'POST',
	           	url:'{{route("district-the-bank")}}',
	           	data:{province_id:province_id,district_id:district_id},
	           	success:function(data){
	            	$('#district').html(data);
	           	}

	        });
		})
	});
</script>
@endsection