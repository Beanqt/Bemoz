<li class="manager-folder-box manager-folder-{{$folder['id']}} col-md-2 col-sm-3 col-xs-4 parent-status{{$folder['active'] ? ' status-active' : ''}}">
    <div class="actions">
        @if(can('documentcategory.edit'))
            <div class="inline">
                <button class="btn btn-info manager-select fas" data-id="{{$folder['id']}}" data-type="folder" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.select')"></button>
            </div>
            <div class="inline">
                <span data-url="{{route('throne.documentcategory.status', $folder['id'])}}" class="status-box change-status{{$folder['active'] ? ' status-active' : ''}}" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.status')">
                    <span class="loader status-loader"></span>
                    <span class="point"></span>
                </span>
            </div>
            <div class="inline">
                <button type="button" data-href="{{route('throne.documentcategory.edit', [$folder['boss'], $folder['id']])}}" class="btn btn-warning btn-xs btn-load modal-link" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.edit')"><i class="fas fa-pencil-alt"></i></button>
            </div>
        @endif
        @if(can('documentcategory.delete'))
            <div class="inline">
                <span class="delete-tooltip" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.delete')">
                    <span data-ajax=".manager-folder-{{$folder['id']}}" data-href="{{route('throne.documentcategory.delete', $folder['id'])}}" data-toggle="modal" data-target=".modal-delete" class="btn btn-danger btn-xs modal-delete-btn" ><i class="far fa-trash-alt"></i></span>
                </span>
            </div>
        @endif
    </div>
    <a class="manager-folder box default-link" data-folder="{{$folder['id']}}" href="{{route('throne.documentcategory.folder', [$folder['id']])}}">
        <div class="icon-box"><i class="fas fa-folder"></i></div>
        <div class="manager-title" title="{{$folder['title']}}">{{$folder['title']}}</div>
        <div class="manager-extension">@lang('admin.documents.folder')</div>
    </a>
    <div class="manager-add-element" data-type="documentcategory" data-id="{{$folder['id']}}" data-title="{{$folder['title']}}">
        <i class="fas fa-cloud-upload-alt"></i> @lang('admin.documents.add')
    </div>
</li>