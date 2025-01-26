<div class="modal fade {{isset($class) ? ' '.$class : ''}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                @if($type == 'main')
                    <div class="form-group group-options">
                        <label>@lang('admin.widget.modules.grid_options.template.title')</label>
                        <select class="form-control form-dynamic-select" data-name="template">
                            <option value="1" {{(isset($options['template']) && $options['template'] == 1) || !isset($options['template']) ? 'selected' : '' }}>@lang('admin.widget.modules.grid_options.template.1')</option>
                            <option value="2" {{isset($options['template']) && $options['template'] == 2 ? 'selected' : ''}}>@lang('admin.widget.modules.grid_options.template.2')</option>
                        </select>
                    </div>
                @else
                    <div class="group-options">
                        <input type="hidden" data-name="column" value="{{$options['column'] ?? '6'}}">
                    </div>
                @endif
                <div class="form-group group-options">
                    <label>@lang('admin.widget.modules.grid_options.class')</label>
                    <input type="text" class="form-control" data-name="class" value="{{$options['class'] ?? ''}}">
                </div>
                <div class="form-group group-styles">
                    <label>@lang('admin.widget.modules.grid_options.background.color')</label>
                    <div class="input-group color-picker">
                        <span class="input-group-addon"><i></i></span>
                        <input type="text" class="form-control" data-name="background-color" value="{{$styles['background-color'] ?? ''}}">
                    </div>
                </div>
                <div class="form-group group-styles">
                    <label>@lang('admin.widget.modules.grid_options.background.image.title')</label>
                    <div class="grid-background-preview{{isset($styles['option-background-id']) && $styles['option-background-id'] ? ' active' : ''}}">
                        <input type="hidden" data-name="option-background-id" value="{{$styles['option-background-id'] ?? ''}}">
                        <input type="hidden" data-name="option-background-type" value="{{$styles['option-background-type'] ?? ''}}">
                        <div class="preview-inside">
                            @if(isset($styles['option-background-type']) && $styles['option-background-type'] == 'gallery' && ($gallery = \App\Models\Gallery::find($styles['option-background-id'])))
                                <div class="image-box"><i class="fas fa-folder"></i></div><div class="preview-title">{{$gallery['title']}}</div>
                            @elseif(isset($styles['option-background-type']) && $styles['option-background-type'] == 'images' && ($image = \App\Models\Images::find($styles['option-background-id'])))
                                <div class="image-box"><img class="img-responsive" src="/uploads/gallery/{{$image['category']}}/small-{{$image['image']}}"></div><div class="preview-title">{{$image['title']}}</div>
                            @endif
                        </div>
                        <span class="dynamic-element-choose-media btn btn-primary btn-block" data-type="gallery">@lang('admin.widget.modules.grid_options.background.image.choose')</span>
                        <span class="dynamic-element-delete-media btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></span>

                        <div class="grid-background-tab grid-background-gallery" style="display: {{isset($styles['option-background-type']) && $styles['option-background-type'] == 'gallery' ? 'block' : 'none'}}">
                            <label>@lang('admin.widget.modules.grid_options.background.image.speed')</label>
                            <input type="number" class="form-control" data-name="option-background-speed" value="{{$styles['option-background-speed'] ?? ''}}">
                        </div>
                        <div class="grid-background-tab grid-background-images" style="display: {{isset($styles['option-background-type']) && $styles['option-background-type'] == 'images' ? 'block' : 'none'}}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>@lang('admin.widget.modules.grid_options.background.image.parallax')</label><br>
                                    <label class="switch">
                                        <input type="checkbox" data-checked-group=".row" data-name="background-attachment" value="fixed" {{isset($styles['background-attachment']) && $styles['background-attachment'] == 'fixed' ? 'checked' : ''}}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label>@lang('admin.widget.modules.grid_options.background.image.animation')</label><br>
                                    <label class="switch">
                                        <input type="checkbox" data-checked-group=".row" data-name="option-animation" value="move" {{isset($styles['option-animation']) && $styles['option-animation'] == 'move' ? 'checked' : ''}}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group group-styles">
                    <label>@lang('admin.widget.modules.grid_options.text.color')</label>
                    <div class="input-group color-picker">
                        <span class="input-group-addon"><i></i></span>
                        <input type="text" class="form-control" data-name="color" value="{{$styles['color'] ?? ''}}">
                    </div>
                </div>
                <div class="form-group group-styles">
                    <label>@lang('admin.widget.modules.grid_options.min_height')</label>
                    <input type="text" class="form-control" data-name="min-height" value="{{$styles['min-height'] ?? ''}}">
                </div>
                <div class="form-group group-styles">
                    <label>@lang('admin.widget.modules.grid_options.align.title')</label>
                    <select class="form-control form-dynamic-select" data-name="justify-content">
                        <option value="flex-start" {{(isset($styles['justify-content']) && $styles['justify-content'] == 'flex-start') || !isset($styles['justify-content']) ? 'selected' : '' }}>@lang('admin.widget.modules.grid_options.align.left')</option>
                        <option value="center" {{isset($styles['justify-content']) && $styles['justify-content'] == 'center' ? 'selected' : ''}}>@lang('admin.widget.modules.grid_options.align.center')</option>
                        <option value="flex-end" {{isset($styles['justify-content']) && $styles['justify-content'] == 'flex-end' ? 'selected' : ''}}>@lang('admin.widget.modules.grid_options.align.right')</option>
                    </select>
                </div>
                <hr>
                <label>@lang('admin.widget.modules.grid_options.padding.title')</label>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group group-styles">
                            <label>@lang('admin.widget.modules.grid_options.padding.top')</label>
                            <input type="text" class="form-control" data-name="padding-top" value="{{$styles['padding-top'] ?? ''}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group group-styles">
                            <label>@lang('admin.widget.modules.grid_options.padding.bottom')</label>
                            <input type="text" class="form-control" data-name="padding-bottom" value="{{$styles['padding-bottom'] ?? ''}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group group-styles">
                            <label>@lang('admin.widget.modules.grid_options.padding.right')</label>
                            <input type="text" class="form-control" data-name="padding-right" value="{{$styles['padding-right'] ?? ''}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group group-styles">
                            <label>@lang('admin.widget.modules.grid_options.padding.left')</label>
                            <input type="text" class="form-control" data-name="padding-left" value="{{$styles['padding-left'] ?? ''}}">
                        </div>
                    </div>
                </div>
                <hr>
                <label>@lang('admin.widget.modules.grid_options.margin.title')</label>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group group-styles">
                            <label>@lang('admin.widget.modules.grid_options.margin.top')</label>
                            <input type="text" class="form-control" data-name="margin-top" value="{{$styles['margin-top'] ?? ''}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group group-styles">
                            <label>@lang('admin.widget.modules.grid_options.margin.bottom')</label>
                            <input type="text" class="form-control" data-name="margin-bottom" value="{{$styles['margin-bottom'] ?? ''}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group group-styles">
                            <label>@lang('admin.widget.modules.grid_options.margin.right')</label>
                            <input type="text" class="form-control" data-name="margin-right" value="{{$styles['margin-right'] ?? ''}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group group-styles">
                            <label>@lang('admin.widget.modules.grid_options.margin.left')</label>
                            <input type="text" class="form-control" data-name="margin-left" value="{{$styles['margin-left'] ?? ''}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('admin.btn.close')</button>
            </div>
        </div>
    </div>
</div>