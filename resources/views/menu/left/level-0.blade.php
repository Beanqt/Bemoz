<div class="clearfix hambibox side-hambibox">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sideMenu" aria-expanded="false">
        <span class="text">@lang('public.menu.side')</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
</div>
<ul class="collapse navbar-collapse level-0" id="sideMenu">
    @foreach($menu as $row)
        @if(isset($row['items']))
            <li class="dropdown {{$menuService->haveActive($row) ? 'active' : ''}}">
                <div class="mobil-dropdown"><i class="fas fa-angle-down"></i></div>
                @include('menu.left.link', ['row' => $row])
                <div class="dropdown-menu">
                    {!! $menuService->createHtml($row['items'], 1) !!}
                </div>
            </li>
        @else
            <li>
                @include('menu.left.link', ['row' => $row])
            </li>
        @endif
    @endforeach
</ul>