@if($service->stats && count($service->stats))
    <div class="staticBoxs row">
        @foreach($service->stats as $key => $stat)
            <div class="staticItem col-lg-2 col-sm-4 col-xs-12">
                <div class="box helpItem">
                    <div class="huge result-{{$key}}">{{$stat}}</div>
                    <div>@lang('admin.'.$service->default.'.table.'.$key)</div>
                </div>
            </div>
        @endforeach
    </div>
@endif