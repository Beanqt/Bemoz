<li class="box" data-type="aszf">
    <div class="title-box">
        <div class="icon"><i class="far fa-file-alt"></i></div>
        <div class="title">@lang('admin.forms.form.menu.aszf')</div>
    </div>
    <ul class="actions">
        <li class="edit btn btn-warning btn-xs"><i class="far fa-edit fa-fw"></i></li>
        <li class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt fa-fw"></i></li>
    </ul>
    <div class="more">
        @include('throne.layouts.forms.inputs.required')
        <div class="form-group">
            <label for="html">@lang('admin.forms.form.elements.aszf')</label>
            <textarea class="form-control ck_textarea" data-name="content" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>{{$item['content'] ?? ''}}</textarea>
        </div>
    </div>
</li>