@extends('admin.layouts.index')

@section('content')
    <div class="page-content">
        <div class="page-header">
            <div class="page-title">
                <h3>Danh sách ngân hàng</h3>
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
                            <th>Tên</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="result-search">
                        @foreach ($banks as $key => $bankItem)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{$bankItem->name_en}} - {{$bankItem->name_vi}}
                                </td>
                                <td>
                                    <a href="{{route('admin.bank.edit', ['id' => $bankItem->id])}}">Sửa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    </div>
@endsection
