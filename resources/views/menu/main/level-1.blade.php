<div class="inside">
    <ul class="level-1 element-{{count($menu) < 3 ? count($menu) : 3}}">
        @php $i = 0; @endphp
        @foreach($menu as $row)
            @if(isset($row['items']))
                @php $i++; @endphp
                @if($i%4 == 0 && $mega)
                    </ul><ul class="level-1 element-{{count($menu) < 3 ? count($menu) : 3}}">
                @endif

                <li class="dropdown">
                    <div class="mobil-dropdown"><i class="fas fa-angle-down"></i></div>
                    @include('menu.main.link', ['row' => $row,'dropdown' => true])
                    {!! $menuService->createHtml($row['items'], 2) !!}
                </li>
            @else
                <li>
                    @include('menu.main.link', ['row' => $row,'dropdown' => false])
                </li>
            @endif
        @endforeach
    </ul>
</div>