<div class="victory__main-menu">
    <ul class="victory__menu-nav">
        {{--<li><a class="victory__menu-nav-link" href="#"> Entry point </a></li>--}}
        @foreach ($items as $item)
            <li><a class="victory__menu-nav-link" href="{{ route('victory.auth.home')}}/{{ $item->name  }}"> {{ $item->name }} </a></li>
        @endforeach
    </ul>
</div>