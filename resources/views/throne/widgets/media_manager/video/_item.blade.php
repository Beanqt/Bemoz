<li class="manager-file-box manager-file-{{$item['id']}} col-md-2 col-sm-3 col-xs-4 parent-status{{$item['active'] ? ' status-active' : ''}}">
    <div class="actions">
        @if(can('videoitem.edit'))
            <div class="inline">
                <button class="btn btn-info manager-select fas" data-id="{{$item['id']}}" data-type="document" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.select')"></button>
            </div>
            <div class="inline">
                <span data-url="{{route('throne.videoitem.status', $item['id'])}}" class="status-box change-status{{$item['active'] ? ' status-active' : ''}}" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.status')">
                    <span class="loader status-loader"></span>
                    <span class="point"></span>
                </span>
            </div>
            <div class="inline">
                <button data-href="{{route('throne.videoitem.edit', [$item['category'],$item['id']])}}" class="btn btn-warning btn-xs btn-load modal-link" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.edit')"><i class="fas fa-pencil-alt"></i></button>
            </div>
        @endif
        @if(can('videoitem.delete'))
            <div class="inline">
                <span class="delete-tooltip" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.delete')">
                    <span data-ajax=".manager-file-{{$item['id']}}" data-href="{{route('throne.videoitem.delete', $item['id'])}}" data-toggle="modal" data-target=".modal-delete" class="btn btn-danger btn-xs modal-delete-btn"><i class="far fa-trash-alt"></i></span>
                </span>
            </div>
        @endif
    </div>
    <div class="manager-file box">
        @if($item['type'] != 4 && empty($item['image']))
            <div class="icon-box">
                <i class="fas fa-play"></i>
            </div>
        @elseif($item['type'] != 4)
            <div class="image-box" style="background: url(/uploads/video/{{$item['category']}}/small-{{$item['image']}}) center center"></div>
        @else
            <div class="image-box" style="background: url(/uploads/video/{{$item['category']}}/{{$item['video_id']}}) center center"></div>
        @endif
        <div class="manager-title" title="{{$item['title']}}">{{$item['title']}}</div>
        <div class="manager-file-datas">
            <div class="manager-extension">@lang('admin.videoitem.type.title'): @lang('admin.videoitem.type.'.$item['type'])</div>
        </div>
    </div>
    <div class="manager-add-element" data-type="video" data-id="{{$item['id']}}" data-title="{{$item['title']}}">
        <i class="fas fa-cloud-upload-alt"></i> @lang('admin.videoitem.add')
    </div>
</li>