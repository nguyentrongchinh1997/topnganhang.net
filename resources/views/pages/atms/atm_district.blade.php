@extends('layouts.index')

@section('title', 'Cây ATM tại ' . $district->name . '-' . $province->name . ' | Điểm đặt cây ATM tại ' .
    $district->name . ' - ' . $province->name)

@section('description', 'Tổng hợp điểm đặt ATM tại ' . $district->name . '-' . $province->name . ', danh sách cây rút
    tiền ATM tại ' . $district->name . ' - ' . $province->name)

@section('content')
    <section>
        <div class="container">
            <div class="row header-inner">
                <div class="col-lg-12">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}"> <i class="fas fa-home"></i>Trang chủ
                            </a></li>
                        <li>
                            <span class="space">/</span>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ url()->current() }}">
                                <span>
                                    Điểm đặt cây ATM ngân hàng {{ $bank->name_en }} tại {{ $district->name }} -
                                    {{ $province->name }}
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
                <div class="col-lg-8">
                    @if(count($atms) > 0)
                        <h3>
                            Cây ATM {{ $bank->name_en }} tại {{ $district->name }} - {{ $province->name }}
                        </h3>
                        <br>
                        <div class="row">
                            @foreach ($atms as $atmItem)
                                <div class="col-lg-6 atm-district">
                                    <div class="job-list border" style="width: 100%">
                                        <a href="{{ route('atm-detail', ['bank_name' => str_slug($bank->name_en), 'address' => $atmItem->slug, 'id' => $atmItem->id]) }}">
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
                        {{ $atms->links() }}
                    @else
                        <div class="alert alert-danger">
                            Cây ATM {{ $bank->name_en }} tại {{ $district->name }} - {{ $province->name }} đang được cập nhật
                        </div>
                    @endif
                </div>
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        @include('pages.includes.bank_tool')
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

        function check() {
            bank = $('#bank').val();

            if (bank == '') {
                alert('Bạn muốn tìm ATM của ngân hàng nào?');

                return false;
            }
            return true;
        }
        province_id = $('#province').val();
        district_id = "{{ $district->id }}";
        $.ajax({
            type: 'POST',
            url: '{{route("district")}}',
            data: {
                province_id: province_id,
                district_id: district_id
            },
            success: function(data) {
                $('#district').html(data);
            }

        });
        $(function() {
            $('#province').change(function() {
                province_id = $(this).val();
                district_id = '';
                $.ajax({
                    type: 'POST',
                    url: '{{route("district")}}',
                    data: {
                        province_id: province_id,
                        district_id: district_id
                    },
                    success: function(data) {
                        $('#district').html(data);
                    }

                });
            })
        });

    </script>
@endsection
