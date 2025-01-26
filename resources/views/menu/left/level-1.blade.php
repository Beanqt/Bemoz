<div class="inside">
    <ul class="level-1">
        @foreach($menu as $row)
            @if(isset($row['items']))
                <li class="dropdown {{count($row['items']) > 8 ? 'lot-submenu' : ''}}">
                    <div class="mobil-dropdown"><i class="fas fa-angle-down"></i></div>
                    @include('menu.left.link', ['row' => $row,'submenu' => true])
                    {!! $menuService->createHtml($row['items'], 2) !!}
                </li>
            @else
                <li>
                    @include('menu.left.link', ['row' => $row,'submenu' => true])
                </li>
            @endif
        @endforeach
    </ul>
</div>