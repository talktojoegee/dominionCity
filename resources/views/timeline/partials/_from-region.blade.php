<select name="regions[]" id="" class="select2 form-control select2-multiple" multiple="multiple">
    <option disabled selected>--Select region(s)--</option>
    @foreach($regions as $region)
        <option value="{{$region->r_id}}">{{ $region->r_name ?? '' }}</option>
    @endforeach
</select>
