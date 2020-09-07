<section>
    <div class="container">
        <form onsubmit="return branchSearch()" method="post" action="{{route('search')}}">
            @csrf
            <div class="row row-custom">
                <div class="col-lg-12">
                    <h2>
                        TÌM KIẾM CHI NHÁNH, PGD CÁC NGÂN HÀNG TRÊN TOÀN QUỐC
                    </h2>
                    <p>
                        Công cụ tìm kiếm chi nhánh, phòng giao dịch nhanh nhất và đầy đủ chi tiết.
                    </p>
                </div>
                <div class="form-group col-md-3 select-border">
                    <select id="bank" name="bank" class="form-control basic-select">
                        <option value="-1" selected="selected">Chọn ngân hàng</option>
                        @foreach ($viewShare['bank'] as $bankItem)
                            <option @if(!empty($bank) && $bank->id == $bankItem->id){{'selected'}}@endif value="{{$bankItem->id}}">
                                {{$bankItem->name_en}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3 select-border">
                    <select id="province" name="province" class="form-control basic-select">
                        <option value="-1" selected="selected">Chọn Tỉnh / Thành phố</option>
                        @foreach ($viewShare['province'] as $provinceItem)
                            <option @if(!empty($province) && $province->id == $provinceItem->id){{'selected'}}@endif value="{{$provinceItem->id}}">
                                {{$provinceItem->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3 select-border">
                    <select id="district" name="district" class="form-control basic-select">
                        <option value="-1" >Chọn Quận / Huyện</option>
                        @if(!empty($province))
                            @foreach($province->district as $districtItem)
                                <option @if(!empty($district) && $district->id == $districtItem->id){{'selected'}}@endif value="{{$districtItem->id}}">{{$districtItem->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-3 select-border">
                    <button class="btn btn-primary mb-2" type="submit">Tìm kiếm</button>
                </div>
            </div>
        </form>
    </div>
</section>
