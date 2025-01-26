<ul class="navbar-collapse level-0" id="menu">
    @foreach($menu as $row)
        @if(isset($row['items']))
            <li class="dropdown{{$row['mega'] ? ' mega' : ' normal'}} nav-dropdown">
                <div class="mobil-dropdown"><i class="fas fa-angle-down"></i></div>
                @include('menu.main.link', ['row' => $row, 'dropdown' => true])

                @if($row['mega'])
                    <div class="dropdown-menu mega">
                        {!! $menuService->createHtml($row['items'], 1, true) !!}
                    </div>
                @else
                    <div class="dropdown-menu normal">
                        {!! $menuService->createHtml($row['items'], 1) !!}
                    </div>
                @endif
            </li>
        @else
            <li>
                @include('menu.main.link', ['row' => $row,'dropdown' => false])
            </li>
        @endif
    @endforeach
</ul>