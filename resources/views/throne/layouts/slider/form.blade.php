<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
            <label for="title">@lang('admin.slider.form.title')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>

            <div class="help-block with-errors">
                {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
    </div>
    <div class="box">
        <div class="form-group">
            <label for="data[title]">@lang('admin.slider.form.title2')</label>
            <input type="text" class="form-control" name="data[title]" id="data[title]" value="{{$data['data']['title'] ?? ''}}">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="data[content]">@lang('admin.slider.form.content')</label>
            <textarea class="form-control" name="data[content]" id="data[content]">{{$data['data']['content'] ?? ''}}</textarea>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="data[url]">@lang('admin.slider.form.link')</label>
            <input type="text" class="form-control" name="data[url]" id="data[url]" value="{{$data['data']['url'] ?? ''}}">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="data[button]">@lang('admin.slider.form.button')</label>
            <input type="text" class="form-control" name="data[button]" id="data[button]" value="{{$data['data']['button'] ?? ''}}">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="data[target]">@lang('admin.slider.form.target.title')</label>
            <select class="form-control form-custom-select" name="data[target]" id="data[target]">
                <option value="0" {{(isset($data['data']['target']) && $data['data']['target']==0) || !isset($data['data']['target']) ? 'selected' : ''}}>@lang('admin.slider.form.target.self')</option>
                <option value="1" {{isset($data['data']['target']) && $data['data']['target']==1 ? 'selected' : ''}}>@lang('admin.slider.form.target.new')</option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="box">
        @include('throne.widgets.public')
        @include('throne.widgets.auth')
    </div>
    <div class="box">
        <div class="form-group {{$errors->has('type') ? 'has-error' : ''}}">
            <label for="type">@lang('admin.slider.form.type.title')<span class="required">*</span></label>
            <select class="form-control form-custom-select" name="type" id="type">
                <option value="0" {{isset($data['type']) && $data['type']==0 || !isset($data['type']) ? 'selected' : ''}}>@lang('admin.slider.form.type.image')</option>
                <option value="1" {{isset($data['type']) && $data['type']==1 ? 'selected' : ''}}>@lang('admin.slider.form.type.video')</option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
        <div class="box-type box-type-0" style="display: {{isset($data['type']) && $data['type']==1 ? 'none' : 'block'}};">
            <div class="form-group {{$errors->has('image') ? 'has-error' : ''}}">
                @include('throne.widgets.slim', [
                    'title' => trans('admin.slider.form.image'),
                    'width' => 1920,
                    'height' => 693,
                    'url' => 'slider',
                    'data' => isset($data) ? $data : ''
                ])

                <div class="help-block with-errors">
                    {!! $errors->first('image', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                </div>
            </div>
        </div>
        <div class="row box-type box-type-1" style="display: {{isset($data['type']) && $data['type']==1 ? 'block' : 'none'}};">
            <div class="col-sm-3">
                <div class="form-group {{$errors->has('mp4') ? 'has-error' : ''}}">
                    @include('throne.widgets.filebox', ['title' => 'MP4', 'type' => 'mp4', 'size' => '500MB', 'folder'=>'slider', 'file' => (isset($data['mp4']) ? $data['mp4'] : '')])
                    <div class="help-block with-errors">
                        {!! $errors->first('mp4', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group {{$errors->has('webm') ? 'has-error' : ''}}">
                    @include('throne.widgets.filebox', ['title' => 'Webm', 'type' => 'webm', 'size' => '500MB', 'folder'=>'slider', 'file' => (isset($data['webm']) ? $data['webm'] : '')])
                    <div class="help-block with-errors">
                        {!! $errors->first('webm', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
        'cancel' => route('throne.slider'),
    ])
</form>

<script>
    $('document').ready(function(){
        $('#type').change(function(){
            var type = $(this).val();
            $('.box-type').hide();
            $('.box-type-'+type).show();
        });
    });
</script>