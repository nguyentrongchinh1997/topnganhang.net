@foreach($district as $districtItem)
	<option value="{{$districtItem->id}}">
		{{$districtItem->name}}
	</option>
@endforeach