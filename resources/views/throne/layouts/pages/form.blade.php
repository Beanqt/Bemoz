<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
            <label for="title">@lang('admin.pages.form.title')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('slug') ? 'has-error' : ''}}">
            <label for="slug">@lang('admin.pages.form.slug')<span class="required">*</span></label>
            <input type="text" class="form-control" name="slug" id="slug" value="{{$data['slug'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('slug', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
    </div>

    @include('throne.widgets.creator.loader', ['name' => 'layout', 'widgets' => [
        'id'=>1,
        'grid'=>true,
        'content'=>true,
        'button'=>true,
        'gallery'=>true,
        'videos'=>true,
        'documents'=>true,
        'forms'=>true,
        'widget_box_list'=>true,
        'widget_category'=>true,
        'widget_counter'=>true,
        'widget_parallax'=>true,
        'widget_tab'=>true,
        'widget_faq'=>true,
        'widget_map'=>true,
    ]])

    <div class="box">
        @include('throne.widgets.template')
        @include('throne.widgets.public')
        @include('throne.widgets.auth')
    </div>
    <div class="box">
        @include('throne.widgets.seo')
    </div>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
        'saveArchived' => true,
        'saveCloseArchived' => true,
        'cancel' => route('throne.pages'),
        'formShow' => true,
    ])
</form>