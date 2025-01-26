<li class="box" data-type="checkbox">
    <div class="title-box">
        <div class="icon"><i class="far fa-check-square"></i></div>
        <div class="title" data-orig-title="@lang('admin.forms.form.menu.checkbox')">{{isset($item['title']) && !empty($item['title']) ? $item['title'] : trans('admin.forms.form.menu.checkbox')}}</div>
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
                @include('throne.layouts.forms.inputs.help')
            </div>
        </div>
        <div class="options-box">
            <div class="option-header">
                @lang('admin.forms.form.elements.option.header')
                <span class="btn btn-primary btn-xs add-option pull-right"><i class="fas fa-plus"></i></span>
            </div>
            <ul class="options">
                @if(isset($item['options']) && count($item['options']))
                    @foreach($item['options'] as $option)
                        @include('throne.layouts.forms.elements.option')
                    @endforeach
                @else
                    @include('throne.layouts.forms.elements.option')
                @endif
            </ul>
        </div>
    </div>
</li>