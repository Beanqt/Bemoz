<form method="post" action="{{route('search')}}" autocomplete="off">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="searchTopBox">
        <div class="input-group">
            <input type="text" class="form-control" name="search" id="main_search" autocomplete="off" placeholder="@lang('public.search.placeholder')" data-error="@lang('public.ajax.error')">
            <span class="input-group-addon" data-toggle="tooltip" data-placement="bottom" title="@lang('public.search.submit')"><button type="submit"><i class="icon icon-search"></i></button></span>
        </div>
        <div class="resultSearch">
            <div class="loader"></div>
            <ul class="hidden">
            </ul>
        </div>
    </div>
</form>