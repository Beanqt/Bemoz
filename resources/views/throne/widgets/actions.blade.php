<div class="actions">
    @if(isset($selectLanguage) && !is_null($selectLanguage))
        <div class="action-item">
            <div class="helpItem" data-help="selectLanguage.{{$selectLanguage ? 1 : 0}}" data-position="right">
                @include('throne.widgets.select_languages', ['all' => $selectLanguage])
            </div>
        </div>
    @endif
    @if(isset($trash) && is_array($trash) && can($permission.'.trash'))
        <div class="action-item">
            <div class="helpItem" data-help="trash" data-position="right">
                <a href="{{$trash['url']}}" class="btn btn-danger btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.trash')"><i class="far fa-trash-alt"></i> ({{$trash['count']}})</a>
            </div>
        </div>
    @endif
    @if(isset($text) && can($permission.'.text'))
        <div class="action-item">
            <div class="helpItem" data-help="text" data-position="right">
                <a href="{{$text}}" class="btn btn-info btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.trans')"><i class="fas fa-font"></i></a>
            </div>
        </div>
    @endif
    @if(isset($publish) && can($permission.'.publish'))
        <div class="action-item">
            <div class="helpItem" data-help="publish" data-position="right">
                <a href="{{$publish}}" class="btn btn-info btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.publishLang')"><i class="fas fa-cloud-upload-alt"></i></a>
            </div>
        </div>
    @endif
    @if(isset($sort) && !empty($sort) && can($permission.'.edit'))
        <div class="action-item">
            <div class="helpItem" data-help="sort" data-position="right">
                <a href="{{$sort}}" class="btn btn-success btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.sort')"><i class="fas fa-sort"></i></a>
            </div>
        </div>
    @endif
    @if(isset($sortSave) && !empty($sortSave))
        <div class="action-item">
            <div class="helpItem" data-help="sort" data-position="right">
                <form method="post" action="{{$sortSave}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="nested" id="nested">
                    <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.order')"><i class="far fa-save"></i></button>
                </form>
            </div>
        </div>
    @endif
    @if(isset($new) && !empty($new) && can($permission.'.new'))
        <div class="action-item">
            <div class="helpItem" data-help="new" data-position="right">
                <a href="{{$new}}" class="btn btn-primary btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.new')"><i class="fas fa-plus"></i></a>
            </div>
        </div>
    @endif
    @if(isset($featured) && !empty($featured) && can($permission.'.edit'))
        <div class="inline">
            <div class="helpItem" data-help="featured" data-position="right">
                <span data-url="{{$featured}}" class="btn btn-xs featuredBox change-status{{$item['featured'] ? ' status-active' : ''}} btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.featured')"><i class="fas fa-star"></i></span>
            </div>
        </div>
    @endif
    @if(isset($status) && !empty($status) && can($permission.'.edit'))
        <div class="inline">
            <div class="helpItem" data-help="status" data-position="right">
                <span data-url="{{$status}}" class="status-box change-status{{$item['active'] ? ' status-active' : ''}}" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.status')">
                    <span class="loader status-loader"></span>
                    <span class="point"></span>
                </span>
            </div>
        </div>
    @endif
    @if(isset($ban, $permission) && can($permission.'.edit'))
        <div class="inline">
            <div class="helpItem" data-help="ban" data-position="right">
                <a href="{{$ban}}" class="btn btn-danger btn-xs btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.ban')"><i class="fas fa-ban"></i></a>
            </div>
        </div>
    @endif
    @if(isset($edit, $permission) && !empty($edit) && can($permission.'.edit'))
        <div class="inline">
            <div class="helpItem" data-help="edit" data-position="right">
                <a href="{{$edit}}" class="btn btn-warning btn-xs btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.edit')"><i class="fas fa-pencil-alt"></i></a>
            </div>
        </div>
    @endif
    @if(isset($delete) && !empty($delete) && can($permission.'.delete'))
        <div class="inline">
            <div class="helpItem" data-help="delete" data-position="right">
                <span class="delete-tooltip" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.delete')">
                    <span data-href="{{$delete}}" class="btn btn-danger btn-xs modal-delete-btn"><i class="far fa-trash-alt"></i></span>
                </span>
            </div>
        </div>
    @endif
    @if(isset($restore) && can($permission.'.trash'))
        <div class="inline">
            <div class="helpItem" data-help="restore" data-position="right">
                <a href="{{$restore}}" class="btn btn-info btn-xs btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.again')"><i class="fas fa-sync-alt"></i></a>
            </div>
        </div>
    @endif
    @if(isset($forceDelete) && can($permission.'.trash'))
        <div class="inline">
            <div class="helpItem" data-help="forceDelete" data-position="right">
                <a href="{{$forceDelete}}" class="btn btn-danger btn-xs btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.forceDelete')"><i class="far fa-trash-alt"></i></a>
            </div>
        </div>
    @endif
    @if(isset($preview) && !empty($preview))
        <div class="inline">
            <div class="helpItem" data-help="preview" data-position="right">
                <a href="{{$preview}}" target="_blank" class="btn btn-warning btn-xs default-link" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.preview')"><i class="fas fa-eye"></i></a>
            </div>
        </div>
    @endif
    @if(isset($show) && !empty($show))
        <div class="inline">
            <a href="{{$show}}" class="btn btn-warning btn-xs btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.show')"><i class="fas fa-eye"></i></a>
        </div>
    @endif
    @if(isset($back) && !empty($back))
        <div class="action-item">
            <div class="helpItem" data-help="back" data-position="right">
                <a href="{{$back}}" class="btn btn-warning btn-load" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.back')"><i class="fas fa-angle-left"></i></a>
            </div>
        </div>
    @endif
    @if(isset($export) && !empty($export) && can($permission.'.export'))
        <div class="action-item">
            <div class="helpItem" data-help="export" data-position="right">
                <a href="{{$export}}" class="btn btn-primary default-link" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.export')"><i class="fas fa-cloud-download-alt"></i></a>
            </div>
        </div>
    @endif
    @if(isset($filter))
        <div class="action-item">
            <div class="helpItem" data-help="filter" data-position="right">
                <button type="submit" name="submit" class="btn btn-primary">@lang('admin.btn.filter')</button>
            </div>
        </div>
    @endif
    @if(isset($saveArchived) && isset($archive_id))
        <div class="action-item">
            <div class="helpItem" data-help="saveArchive" data-position="top-left">
                <button type="submit" class="btn btn-success btn-icon"><i class="far fa-save"></i> @lang('admin.btn.saveArchive')</button>
            </div>
        </div>
    @endif
    @if(isset($saveCloseArchived) && isset($archive_id))
        <div class="action-item">
            <div class="helpItem" data-help="saveCloseArchive" data-position="top left">
                <button type="submit" class="btn btn-primary btn-icon" onclick="changeSubmit(this, 2)"><i class="far fa-save"></i> @lang('admin.btn.saveCloseArchive')</button>
            </div>
        </div>
    @endif
    @if(isset($save) && !isset($archive_id))
        <div class="action-item">
            <div class="helpItem" data-help="save" data-position="top left">
                <button type="submit" class="btn btn-success btn-icon"><i class="far fa-save"></i> @lang('admin.btn.save')</button>
            </div>
        </div>
    @endif
    @if(isset($saveClose) && !isset($archive_id))
        <div class="action-item">
            <div class="helpItem" data-help="saveClose" data-position="top left">
                <button type="submit" class="btn btn-primary btn-icon" onclick="changeSubmit(this, 2)"><i class="far fa-save"></i> @lang('admin.btn.saveClose')</button>
            </div>
        </div>
    @endif
    @if(isset($saveNew) && !isset($edit))
        <div class="action-item">
            <div class="helpItem" data-help="saveNew" data-position="top left">
                <button type="submit" class="btn btn-info btn-icon" onclick="changeSubmit(this, 3)"><i class="fas fa-plus"></i> @lang('admin.btn.saveNew')</button>
            </div>
        </div>
    @endif
    @if(isset($formShow) && !isset($archive_id))
        <div class="action-item">
            <div class="helpItem" data-help="preview" data-position="top left">
                @if(session('show'))
                    {!! session('show') !!}
                @endif
                <button type="submit" class="btn btn-warning btn-icon" onclick="changeSubmit(this, 4)"><i class="fas fa-eye"></i> @lang('admin.btn.preview')</button>
            </div>
        </div>
    @endif
    @if(isset($cancel))
        <div class="action-item">
            <div class="helpItem" data-help="back" data-position="top left">
                <a href="{{$cancel}}" class="btn btn-cancel btn-icon btn-load"><i class="fas fa-times"></i> @lang('admin.btn.cancel')</a>
            </div>
        </div>
    @endif
    @if(isset($upload))
        <div class="action-item">
            <form method="post" class="upload-form" action="{{$upload}}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="file" class="uploadFileInput" name="file" id="file" accept=".xml">
                <label for="file" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.btn.xml')">
                    <i class="fas fa-cloud-upload-alt"></i>
                </label>
            </form>
        </div>
    @endif
</div>