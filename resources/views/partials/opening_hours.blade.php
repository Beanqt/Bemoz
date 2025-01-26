<ul class="opening-box">
    @foreach($data['opening'] as $key => $item)
        <li class="row inline-row">
            <div class="col-sm-6 inline-col opening-title">{{trans('public.opening_hours.days.'.$key)}}</div>
            <ul class="col-sm-6 inline-col opening-hours">
                @if(!empty($item['simple']))
                    @foreach($item['simple'] as $hit)
                        @foreach($hit as $hours)
                            <li>{{$hours}}</li>
                        @endforeach
                    @endforeach
                @else
                    <li>@lang('public.'.(isset($opening_path) ? $opening_path : 'opening_hours').'.no_opening')</li>
                @endif
            </ul>
        </li>
    @endforeach
</ul>
