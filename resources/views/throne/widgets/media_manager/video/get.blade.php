@if(count($folders))
    @foreach($folders as $folder)
        @include('throne.widgets.media_manager.video._folder_item')
    @endforeach
@endif
@if(count($files))
    @foreach($files as $item)
        @include('throne.widgets.media_manager.video._item')
    @endforeach
@endif

@if(!count($folders) && !count($files))
    <li class="col-xs-12 manager-empty">
        @lang('admin.documents.alerts.empty')
    </li>
@endif