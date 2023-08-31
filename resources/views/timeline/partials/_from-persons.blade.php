<select name="persons[]"  class="select2 form-control select2-multiple" multiple="multiple">
    <option disabled selected>--Select person(s)--</option>
    @foreach($users as $user)
        <option value="{{$user->id}}">{{ $user->title ?? '' }} {{ $user->first_name ?? '' }} {{ $user->last_name ?? '' }}</option>
    @endforeach
</select>
