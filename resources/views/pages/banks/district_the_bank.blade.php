<option value="">Chọn Quận / Huyện</option>
@foreach($district as $districtItem)
<option @if($district_id == $districtItem->id){{'selected'}}@endif value="{{$districtItem->id}}">
        {{$districtItem->name}}
    </option>
@endforeach
