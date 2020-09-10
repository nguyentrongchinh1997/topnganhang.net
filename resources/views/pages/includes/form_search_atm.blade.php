<form method="post" action="{{route('atm-search')}}" onsubmit="return check()">
    @csrf
    <div class="row row-custom">
        <div class="col-lg-12">
            <h2>
                ĐIỂM ĐẶT CÂY ATM CÁC NGÂN HÀNG TRÊN TOÀN QUỐC
            </h2>
            <p>
                Công cụ tìm kiếm điểm đặt cây ATM gần nhất một cách nhanh nhất và đầy đủ chi tiết.
            </p>
        </div>
        <div class="form-group col-md-3 select-border">
            <select id="bank" name="bank" class="form-control basic-select">
                <option value="" selected="selected">Chọn ngân hàng</option>
                @foreach ($viewShare['bank'] as $bankItem)
                    <option @if(!empty($bank) && $bank->id == $bankItem->id){{'selected'}}@endif value="{{$bankItem->id}}">
                        {{$bankItem->name_en}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3 select-border">
            <select id="province" name="province" class="form-control basic-select">
                <option value="" selected="selected">Chọn Tỉnh / Thành phố</option>
                @foreach ($viewShare['province'] as $provinceItem)
                    <option @if(!empty($province) && $province->id == $provinceItem->id){{'selected'}}@endif value="{{$provinceItem->id}}">
                        {{$provinceItem->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3 select-border">
            <select id="district" name="district" class="form-control basic-select">
                <option value="" selected="selected">Chọn Quận / Huyện</option>
            </select>
        </div>
        <div class="form-group col-md-3 select-border">
            <button class="btn btn-primary mb-2" type="submit">Tìm kiếm</button>
        </div>
    </div>
</form>