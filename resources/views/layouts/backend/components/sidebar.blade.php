<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">{{ __('pages.title') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">{{ __('pages.brand') }}</a>
        </div>
        <ul class="sidebar-menu">
            @foreach($menu as $m)
            @if (count($m->SubMenu) == 0)
            <li class="@if ($m->hover != null)
                @foreach (json_decode($m->hover) as $h){{ URL::current() == $h ? 'active' : '' }}@endforeach
                @endif">
                <a href="{{ $m->url }}" class="nav-link">
                    <i class="fas {{ $m->icon }}"></i><span>{{ $m->name }}</span>
                </a>
            </li>
            @else
            <li class="nav-item dropdown @if ($m->hover != null)
                @foreach (json_decode($m->hover) as $h){{ URL::current() == $h ? 'active' : '' }}@endforeach
                @endif
                @foreach ($m->SubMenu as $s)@if ($s->hover != null)@foreach (json_decode($s->hover) as $sub)
                {{ URL::current() == $sub ? 'active' : '' }}
                @endforeach @endif @endforeach">
                <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas {{ $m->icon }}"></i>
                    <span>{{ $m->name }}</span>
                </a>
                <ul class="dropdown-menu">
                    @foreach($m->SubMenu as $sm)
                    <li class="@if ($sm->hover != null)@foreach (json_decode($sm->hover) as $h)
                        {{ URL::current() == $h ? 'active' : '' }}@endforeach @endif">
                        <a class="nav-link" href="{{ $sm->url }}">{{ $sm->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endif
            @endforeach
        </ul>
    </aside>
</div>