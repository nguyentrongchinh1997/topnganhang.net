@extends('admin.layouts.index')

@section('content')
    <div class="page-content">
        <div class="page-header">
            <div class="page-title">
                <h3>Danh sách tin tức</h3>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="">Trang chủ</a></li>
                <li><a href="tables_dynamic.html">Danh sách</a></li>
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
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="panel panel-default">
            <div class="datatable">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td colspan="8">
                                <button style="float: right;" type="button" class="input-control btn btn-primary">
                                    <a href="{{ route('admin.news.add.form') }}" style="color: #fff">
                                        Thêm
                                    </a>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Lượt xem</th>
                            <th>Nguồn</th>
                            <th>Ngày đăng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="result-search">
                        @foreach ($news as $key => $newsItem)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    <img src='{{ asset("upload/thumbnails/$newsItem->image") }}' alt="">
                                </td>
                                <td>
                                <a target="_blank" href="{{route('news-detail', ['slug' => $newsItem->slug, 'id' => $newsItem->id])}}">
                                        {{ $newsItem->title }}
                                    </a>
                                </td>
                                <td>
                                    {{ $newsItem->view }}
                                </td>
                                <td>
                                    {{ $newsItem->author }}
                                </td>
                                <td>
                                    {{ date('d/m/Y', strtotime($newsItem->created_at)) }}
                                </td>
                                <td>
                                    <a
                                        href="{{ route('admin.news.edit.form', ['id' => $newsItem->id]) }}">Sửa</a> / 
                                    <a onclick="return newsDelete()"
                                        href="{{ route('admin.news.delete', ['id' => $newsItem->id]) }}">Xóa</a>
                                </td>
                                <script>
                                    function newsDelete() {
                                        if (confirm('Bạn có chắc chắn muốn xóa tin này?')) {
                                            return true;
                                        }

                                        return false;
                                    }
                                </script>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    </div>
@endsection
