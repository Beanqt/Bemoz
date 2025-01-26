<li class="box {{$newsletter ? 'disabled' : ''}}" data-type="newsletter">
    <div class="title-box">
        <div class="icon"><i class="far fa-envelope"></i></div>
        <div class="title">@lang('admin.forms.form.menu.newsletter')</div>
    </div>
    <ul class="actions">
        <li class="edit btn btn-warning btn-xs"><i class="far fa-edit fa-fw"></i></li>
        <li class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt fa-fw"></i></li>
    </ul>
    <div class="more">
        <div class="form-group no-margin">
            <div class="row">
                <div class="col-sm-3">
                    @include('throne.layouts.forms.inputs.required')
                </div>
                <div class="col-sm-3">
                    @include('throne.layouts.forms.inputs.hidden')
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="html">@lang('admin.forms.form.elements.newsletter')</label>
            <textarea class="form-control ck_textarea" data-name="content" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>{{$item['content'] ?? ''}}</textarea>
        </div>
    </div>
</li>