<div class="page-header">
    <button type="button" class="manager-close" data-dismiss="modal"><i class="fas fa-times"></i></button>
    <div class="media-actions actions">
        @if(can('documentcategory.edit'))
            <div class="action-item">
                <button type="button" data-href="{{route('throne.mediamanager.api.paste', ['documents', '[boss]'])}}" class="btn btn-primary btn-load btn-icon btn-sm manager-paste hidden"><i class="far fa-copy"></i> @lang('admin.documents.paste') <span></span></button>
            </div>
        @endif
        @if(can('documentcategory.export'))
            <div class="action-item">
                <button type="button" data-href="{{route('throne.mediamanager.api.downloadzip', ['documents', '[boss]'])}}" class="btn btn-primary download-zip btn-icon btn-sm" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="@lang('admin.btn.export')"><i class="fas fa-cloud-download-alt"></i> @lang('admin.documents.export')</button>
            </div>
        @endif
        @if(can('documentcategory.new'))
            <div class="action-item">
                <button type="button" data-href="{{route('throne.documentcategory.new', '[boss]')}}" class="btn btn-primary modal-link btn-load btn-icon btn-sm" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="@lang('admin.btn.new')"><i class="fas fa-plus"></i> @lang('admin.documents.new_folder')</button>
            </div>
        @endif
        @if(can('documentitem.new'))
            <div class="action-item">
                <button type="button" class="btn btn-primary btn-icon btn-sm new-dropzone" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="@lang('admin.btn.new')"><i class="fas fa-plus"></i> @lang('admin.documents.new_file')</button>
            </div>
        @endif
    </div>
    <h1>@lang('admin.documentitem.title')</h1>
</div>
@if(can('documentitem.new'))
    <div class="dropzone" data-maxsize="{{setting('upload_document') ? setting('upload_document') : 100}}" data-msg="<i class='fas fa-cloud-upload-alt'></i> @lang('admin.dropzone.upload')">
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
    </div>
@endif
<div class="manager-view">
    <button type="button" {!! session('media_manager_view') == 2 ? 'class="active"' : '' !!} data-type="list"><i class="fas fa-fw fa-bars"></i></button>
    <button type="button" {!! session('media_manager_view') != 2 ? 'class="active"' : '' !!} data-type="grid"><i class="fas fa-fw fa-th-large"></i></button>
</div>
<div class="manager-search">
    <div class="input-group">
        <input type="text" class="form-control manager-search-input">
        <div class="input-group-addon">
            <i class="fas fa-search"></i>
        </div>
    </div>
</div>
<ul class="media-breadcrumbs">
    <li class="home"><a href="{{route('throne.documentcategory')}}" class="manager-folder default-link" data-folder="0"><i class="fas fa-home"></i></a></li>
    @foreach($breadcrumbs as $breadcrumb)
        <li><a href="{{route('throne.documentcategory.folder', $breadcrumb['id'])}}" class="manager-folder default-link" data-folder="{{$breadcrumb['id']}}">{{$breadcrumb['title']}}</a></li>
    @endforeach
</ul>
<ul class="media-content view-{{session('media_manager_view') == 2 ? 'list' : 'grid'}} clearfix">
    @include('throne.widgets.media_manager.documents.get')
</ul>