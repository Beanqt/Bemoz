<div class="inside dropdown-menu">
    <ul class="level-2">
        @foreach($menu as $row)
            @if(isset($row['items']))
                <li class="dropdown">
                    <div class="mobil-dropdown"><i class="fas fa-angle-down"></i></div>
                    @include('menu.left.link', ['row' => $row,'submenu' => true])
                    {!! $menuService->createHtml($row['items'], 4) !!}
                </li>
            @else
                <li>
                    @include('menu.left.link', ['row' => $row,'submenu' => true])
                </li>
            @endif
        @endforeach
    </ul>
</div>