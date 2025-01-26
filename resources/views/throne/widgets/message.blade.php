<div class="helpBox helpBoxItem" data-index="{{$help_index}}" data-name="{{$help_name}}">
    <div class="helpBg"></div>
    <div class="helpMessage {{$help_position}}">
        @lang('help.'.$help_name.'.desc')
        <div class="helpAction">
            <span class="btn btn-xs btn-primary helpNext btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('help.next')"><i class="fas fa-angle-right fa-fw"></i></span>
            <span class="btn btn-xs btn-danger helpSkip btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('help.skip')"><i class="fas fa-times-circle fa-fw"></i></span>
        </div>
    </div>
</div>