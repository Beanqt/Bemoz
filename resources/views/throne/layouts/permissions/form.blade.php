<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
            <label for="title">@lang('admin.permissions.form.name')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
    </div>
    @foreach($permissions as $key => $values)
        <label for="permission">@lang('admin.'.$key.'.permission')</label>
        <div class="box">
            <label class="checkBoxInput all">
                <input type="checkbox" name="permission_all[{{$key}}]" id="permission_all[{{$key}}]">
                <span></span> @lang('admin.permissions.form.all')
            </label>

            <span style="margin-right: 15px;"></span>

            @foreach($values as $value)
                <label class="checkBoxInput">
                    <input type="checkbox" name="permission[{{$key}}][{{$value}}]" id="permission[{{$key}}][{{$value}}]" {{isset($data['permission'][$key][$value]) ? 'checked' : ''}}>
                    <span></span> @lang('admin.permissions.form.'.$value)
                </label>

                <span style="margin-right: 15px;"></span>
            @endforeach
        </div>
    @endforeach

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
        'cancel' => route('throne.permissions'),
    ])
</form>
<script>
    $('.all').click(function(){
        var el = $(this);
        var checked = el.find('input').prop('checked');

        el.parent().find('input').each(function(){
            $(this).prop('checked', checked);
        });
    });
</script>