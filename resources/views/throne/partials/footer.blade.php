<div class="modal fade modal-widget-manager modal-documents-manager">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body media-manager media-documents-manager clearfix" data-type="documents" data-boss="0">
                <div class="loader active"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-widget-manager modal-gallery-manager">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body media-manager media-gallery-manager clearfix" data-type="gallery" data-boss="0">
                <div class="loader active"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-widget-manager modal-video-manager">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body media-manager media-video-manager clearfix" data-type="video" data-boss="0">
                <div class="loader active"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-manager">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-delete modal-danger">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('admin.modal_delete.head')</h4>
            </div>
            <div class="modal-body">
                @lang('admin.modal_delete.body')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin.btn.no')</button>
                <a href="" class="btn btn-danger btn-load" data-modal-accept="true">@lang('admin.btn.yes')</a>
            </div>
        </div>
    </div>
</div>

<div class="version">v{{getenv('VERSION')}}</div>