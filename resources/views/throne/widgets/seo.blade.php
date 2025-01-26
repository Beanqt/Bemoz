<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="seo_title">@lang('admin.widget.seo.title')</label>
            <input type="text" class="form-control" name="seo_title" id="seo_title" value="{{$data['seo']['title'] ?? (isset($data['seo_title']) ? $data['seo_title'] : '')}}">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="seo_keywords">@lang('admin.widget.seo.keywords')</label>
            <input type="text" class="form-control" name="seo_keywords" id="seo_keywords" value="{{$data['seo']['keywords'] ?? (isset($data['seo_keywords']) ? $data['seo_keywords'] : '')}}">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="seo_desc">@lang('admin.widget.seo.desc') <small>@lang('admin.widget.seo.max')</small></label>
            <textarea class="form-control" maxlength="160" name="seo_desc" id="seo_desc">{{$data['seo']['desc'] ?? (isset($data['seo_desc']) ? $data['seo_desc'] : '')}}</textarea>
            <div class="help-block with-errors"></div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <label for="addthis">@lang('admin.widget.addthis.title')</label><br>
                <label class="switch">
                    <input type="checkbox" name="addthis" id="addthis" {{(isset($data['seo']['addthis']) && $data['seo']['addthis']) || (isset($data['addthis']) && $data['addthis']) ? 'checked' : (!isset($data['seo']['addthis']) && !isset($data['addthis']) ? 'checked' : '')}}>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="col-sm-5">
                <label for="nofollow">@lang('admin.widget.nofollow.title')</label><br>
                <label class="switch">
                    <input type="checkbox" name="nofollow" id="nofollow" {{(isset($data['seo']['nofollow']) && $data['seo']['nofollow']) || (isset($data['nofollow']) && $data['nofollow']) ? 'checked' : ''}}>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group {{$errors->has('seo_image') ? 'has-error' : ''}}">
            @include('throne.widgets.slim', [
                'title' => trans('admin.widget.seo.image'),
                'width' => 1200,
                'height' => 600,
                'name' => 'seo_image',
                'url' => 'seo',
                'imageremove'=>'seo',
                'data' => ['image'=>isset($data['seo']['image']) ? $data['seo']['image'] : '', 'image_crop' => isset($data['seo']['image_crop']) ? $data['seo']['image_crop'] : '']
            ])

            <div class="help-block with-errors">
                {!! $errors->first('seo_image', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
    </div>
</div>