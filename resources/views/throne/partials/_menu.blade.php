@if(count($items) > 1)
    @if(count($allowed = array_filter($items, function($item){ return can($item.'.read'); })))
        <li class="dropdown {{ activeMenu($allowed) ? 'active' : '' }}">
            <span class="dropdown-li"><i class="{{$icon}} fa-fw"></i> @lang('admin.'.$items[0].'.main')<span class="fas arrow"></span></span>
            <ul class="dropdownBox clearfix">
                @foreach($allowed as $item)
                    <li><a href="{{ route('throne.'.$item) }}">@lang('admin.'.$item.'.title')</a></li>
                @endforeach
            </ul>
        </li>
    @endif
@elseif(($item = $items[0]) && can($item.'.read'))
    <li class="{{ activeMenu($item)  ? 'active' : '' }}">
        <a href="{{ route('throne.'.$item) }}"><i class="{{$icon}} fa-fw"></i> @lang('admin.'.$item.'.title')</a>
    </li>
@endif