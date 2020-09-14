@extends('admin.layouts.index')

@section('content')
    <div class="page-content">
        <div class="page-header">
            <div class="page-title">
                <h3>Sửa ngân hàng {{ $bank->name_en }}</h3>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="">Trang chủ</a></li>
                <li><a href="#">Sửa ngân hàng {{ $bank->name_en }}</a></li>
            </ul>
            <div class="visible-xs breadcrumb-toggle">
                <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i
                        class="icon-menu2"></i></a>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (count($errors->all()) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{ route('admin.bank.edit', ['id' => $bank->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Tên tiếng việt <span class="mandatory">*</span></label>
                                <input value="{{ $bank->name_vi }}" required="required" type="text" class="form-control"
                                    name="name_vi">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Tên tiếng anh<span class="mandatory">*</span></label>
                                <input value="{{ $bank->name_en }}" required="required" type="text" class="form-control"
                                    name="name_en">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mổ tả ngắn <span class="mandatory">*</span></label>
                        <textarea required="required" name="description" class="form-control ckeditor" rows="5"
                            placeholder="Mô tả...">{{ $bank->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Giới thiệu <span class="mandatory">*</span></label>
                        <textarea required="required" name="content" id="content-ckeditor"
                            class="form-control ckeditor">{!! $bank->content !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Lãi suất</label>
                        <textarea required="required" name="interest" id="content-ckeditor1"
                            class="form-control ckeditor">
                            @if(!empty($bank->interestRate->content))
                                {!!$bank->interestRate->content!!}
                            @endif
                        </textarea>
                    </div>
                    <div class="form-group">
                        <center>
                            <button type="submit" class="btn btn-primary">Hoàn thành</button>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
