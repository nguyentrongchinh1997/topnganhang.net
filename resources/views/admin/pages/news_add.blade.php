@extends('admin.layouts.index')

@section('content')
    <div class="page-content">
        <div class="page-header">
            <div class="page-title">
                <h3>Thêm bài viết</h3>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="">Trang chủ</a></li>
                <li><a href="#">Thêm bài viết</a></li>
            </ul>
            <div class="visible-xs breadcrumb-toggle">
                <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i
                        class="icon-menu2"></i></a>
            </div>
        </div>
        @if (session('alert'))
            <div class="alert alert-danger">
                {{ session('alert') }}
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
                <form action="{{ route('admin.news.add') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Tiêu đề <span class="mandatory">*</span></label>
                                <input placeholder="Nhập tiêu đề..." required="required" type="text" class="form-control"
                                    name="title">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Hình ảnh <span class="mandatory">*</span></label>
                                <input required="required" type="file" name="img" class="styled">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Nguồn</label>
                                <input type="text" class="form-control" name="author" placeholder="vd: báo lao động...">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Từ khóa (nhập và ấn enter) <span
                                        class="mandatory">*</span></label>
                                <input required="required" name="tags" type="text" id="tags2" class="tags">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tóm tắt <span class="mandatory">*</span></label>
                        <textarea required="required" name="description" class="form-control ckeditor" rows="5"
                            placeholder="Mô tả..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nội dung <span class="mandatory">*</span></label>
                        <textarea required="required" name="content" id="content-ckeditor"
                            class="form-control ckeditor"></textarea>
                    </div>
                    <div class="form-group">
                        <center>
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
