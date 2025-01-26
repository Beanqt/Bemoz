<form method="post" action="{{isset($edit) ? route('throne.videogallery.edit', [$boss, $edit]) : route('throne.videogallery.new', $boss)}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="row">
            <div class="col-sm-7">
                <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                    <label for="title">@lang('admin.videogallery.form.title')<span class="required">*</span></label>
                    <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
                    <div class="help-block with-errors">
                        {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
                <div class="form-group {{$errors->has('slug') ? 'has-error' : ''}}">
                    <label for="slug">@lang('admin.videogallery.form.slug')</label>
                    <input type="text" class="form-control" name="slug" id="slug" value="{{$data['slug'] ?? ''}}">
                    <div class="help-block with-errors">
                        {!! $errors->first('slug', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <label for="title">@lang('admin.videogallery.form.image')</label>
                    @include('throne.widgets.slim', ['width'=>800,'height'=>400,'url'=>'video','imageremove'=>true,'data'=>isset($data) ? $data : ''])
                </div>
            </div>
        </div>
    </div>
    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
    ])
</form>