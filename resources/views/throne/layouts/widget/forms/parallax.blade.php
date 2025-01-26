<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group">
            <label for="title">@lang('admin.widget.parallax.form.title')<span class="required">*</span></label>
            <input type="text" class="form-control" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="option[height]">@lang('admin.widget.parallax.form.height')</label>
            <input type="text" class="form-control" name="option[height]" id="option[height]" value="{{$data['option']['height'] ?? '500px'}}">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            @include('throne.widgets.slim', ['title'=>trans('admin.widget.parallax.form.image'),'width'=>1920,'height'=>900,'name'=>'option[slim]','imageremove'=>true,'url'=>'widget/parallax','data'=>isset($data['option']) ? $data['option'] : ''])
        </div>
    </div>
    <div class="box">
        <div class="row">
            <div class="col-sm-6">
                <label>@lang('admin.widget.parallax.form.animation')</label><br>
                <label class="switch">
                    <input type="checkbox" name="option[animation]" {{isset($data['option']['animation']) && $data['option']['animation'] ? 'checked' : ''}}>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'cancel' => route('throne.widget'),
    ])
</form>