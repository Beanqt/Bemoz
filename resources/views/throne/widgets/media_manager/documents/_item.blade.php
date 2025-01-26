<li class="manager-file-box manager-file-{{$item['id']}} col-lg-2 col-md-3 col-sm-4 col-xs-6 parent-status{{$item['active'] ? ' status-active' : ''}}">
    <div class="actions">
        @if(can('documentitem.edit'))
            <div class="inline">
                <button class="btn btn-info manager-select fas" data-id="{{$item['id']}}" data-type="document" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.select')"></button>
            </div>
            <div class="inline">
                <span data-url="{{route('throne.documentitem.status', $item['id'])}}" class="status-box change-status{{$item['active'] ? ' status-active' : ''}}" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.status')">
                    <span class="loader status-loader"></span>
                    <span class="point"></span>
                </span>
            </div>
            <div class="inline">
                <button type="button" data-href="{{route('throne.documentitem.edit', [$item['category'],$item['id']])}}" class="btn btn-warning btn-xs btn-load modal-link" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.edit')"><i class="fas fa-pencil-alt"></i></button>
            </div>
        @endif
        @if(can('documentitem.delete'))
            <div class="inline">
                <span class="delete-tooltip" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.delete')">
                    <span data-ajax=".manager-file-{{$item['id']}}" data-href="{{route('throne.documentitem.delete', $item['id'])}}" data-toggle="modal" data-target=".modal-delete" class="btn btn-danger btn-xs modal-delete-btn"><i class="far fa-trash-alt"></i></span>
                </span>
            </div>
        @endif
    </div>
    <div class="manager-file box">
        @if(empty($item['image']))
            <div class="icon-box">
                {!! getIcon($item['file']) !!}
            </div>
        @else
            <div class="image-box" style="background: url(/uploads/documentitem/{{$item['category']}}/image/small-{{$item['image']}}) center center"></div>
        @endif
        <div class="manager-title" title="{{$item['title']}}">{{$item['title']}}</div>
        <div class="manager-file-datas">
            <div class="manager-extension">@lang('admin.documents.extension'): .{{fileExtension($item['file'])}}</div>
            <div class="manager-size">@lang('admin.documents.size'): {{$item['size']}}MB</div>
            <div class="manager-download" title="@lang('admin.documents.download')"><i class="fas fa-cloud-download-alt"></i> {{count($item['downloads'])}}</div>
        </div>
    </div>
    <div class="manager-add-element" data-type="document" data-id="{{$item['id']}}" data-title="{{$item['title']}}">
        <i class="fas fa-cloud-upload-alt"></i> @lang('admin.documents.add')
    </div>
</li>