<form{!! $attributes !!}>
    @foreach($elements as $element)
    {!! $element->render() !!}
    @endforeach
</form>
