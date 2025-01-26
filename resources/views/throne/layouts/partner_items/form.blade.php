<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
            <label for="title">@lang('admin.partner_items.form.title')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group {{$errors->has('url') ? 'has-error' : ''}}">
            <label for="url">@lang('admin.partner_items.form.url')<span class="required">*</span></label>
            <input type="text" class="form-control" name="url" id="url" value="{{$data['url'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('link', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group">
            <label for="target">@lang('admin.partner_items.form.target.title')</label><br>
            <select class="form-control form-custom-select" name="target" id="target">
                <option value="0" {{!isset($data['target']) || (isset($data['target']) && $data['target'] == 0) ? 'selected' : ''}}>@lang('admin.partner_items.form.target.0')</option>
                <option value="1" {{isset($data['target']) && $data['target'] == 1 ? 'selected' : ''}}>@lang('admin.partner_items.form.target.1')</option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="box">
        @include('throne.widgets.public')
        <div class="form-group">
            <label for="category">@lang('admin.partner_items.form.category.title')</label>
            <select class="form-control form-custom-select" name="category" id="category">
                <option value="" {{!isset($data['category']) || (isset($data['category']) && $data['category'] == '') ? 'selected' : ''}}>@lang('admin.partner_items.form.category.placeholder')</option>
                @foreach($categories as $item)
                    <option value="{{$item['id']}}" {{isset($data['category']) && $item['id'] == $data['category'] ? 'selected' : ''}}>{{$item['title']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="box">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group {{$errors->has('image') ? 'has-error' : ''}}">
                    <label for="title">@lang('admin.partner_items.form.image')<span class="required">*</span></label>
                    @include('throne.widgets.slim', ['width'=>117,'height'=>61,'url'=>'partner_items','data'=>isset($data) ? $data : ''])

                    <div class="help-block with-errors">
                        {!! $errors->first('image', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
        'cancel' => route('throne.partner_items'),
    ])
</form>
