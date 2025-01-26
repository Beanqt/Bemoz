<li class="box" data-type="html">
    <div class="title-box">
        <div class="icon"><i class="fas fa-paragraph"></i></div>
        <div class="title" data-orig-title="@lang('admin.forms.form.menu.html')">{{isset($item['title']) && !empty($item['title']) ? $item['title'] : trans('admin.forms.form.menu.html')}}</div>
    </div>
    <ul class="actions">
        <li class="edit btn btn-warning btn-xs"><i class="far fa-edit fa-fw"></i></li>
        <li class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt fa-fw"></i></li>
    </ul>
    <div class="more">
        @include('throne.layouts.forms.inputs.title')
        <div class="form-group">
            <label for="html">@lang('admin.forms.form.elements.html')</label>
            <textarea class="form-control ck_textarea" data-name="content" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>{{$item['content'] ?? ''}}</textarea>
        </div>
    </div>
</li>