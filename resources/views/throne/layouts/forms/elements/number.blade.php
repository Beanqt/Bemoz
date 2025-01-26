<li class="box" data-type="number">
    <div class="title-box">
        <div class="icon"><i class="fas fa-sort-numeric-down"></i></div>
        <div class="title" data-orig-title="@lang('admin.forms.form.menu.number')">{{isset($item['title']) && !empty($item['title']) ? $item['title'] : trans('admin.forms.form.menu.number')}}</div>
    </div>
    <ul class="actions">
        <li class="edit btn btn-warning btn-xs"><i class="far fa-edit fa-fw"></i></li>
        <li class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt fa-fw"></i></li>
    </ul>
    <div class="more">
        @include('throne.layouts.forms.inputs.title')
        @include('throne.layouts.forms.inputs.required')
        <div class="row">
            <div class="col-md-6">
                @include('throne.layouts.forms.inputs.label')
            </div>
            <div class="col-md-6">
                @include('throne.layouts.forms.inputs.placeholder')
            </div>
        </div>
        @include('throne.layouts.forms.inputs.help')
        <div class="row">
            <div class="col-md-6">
                @include('throne.layouts.forms.inputs.min', ['number' => true])
            </div>
            <div class="col-md-6">
                @include('throne.layouts.forms.inputs.max', ['number' => true])
            </div>
        </div>
    </div>
</li>