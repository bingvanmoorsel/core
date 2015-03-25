<select{!! $attributes !!}>
    @foreach($options as $value => $label)
        <option {!! $value == $selected ? 'selected="selected"' : '' !!} value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select>
