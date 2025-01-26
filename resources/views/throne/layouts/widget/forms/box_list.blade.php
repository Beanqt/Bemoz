<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <input type="hidden" class="data" name="data">

    <ul class="panelMenu clearfix">
        <li class="active" data-id="default"><i class="fas fa-cogs fa-fw"></i> @lang('admin.widget.menu.default')</li>
        <li data-id="style"><i class="fas fa-palette fa-fw"></i> @lang('admin.widget.menu.style')</li>
    </ul>

    <div class="panels">
        <div class="panel panel-default active">
            <div class="box">
                <div class="form-group">
                    <label for="title">@lang('admin.widget.box_list.form.title')<span class="required">*</span></label>
                    <input type="text" class="form-control" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="option[column]">@lang('admin.widget.box_list.form.column')</label>
                    <select class="form-control form-custom-select" name="option[column]" id="option[column]">
                        <option value="6" {{!isset($data['option']['column']) || (isset($data['option']['column']) && $data['option']['column']==6) ? 'selected' : ''}}>2</option>
                        <option value="4" {{isset($data['option']['column']) && $data['option']['column']==4 ? 'selected' : ''}}>3</option>
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        @include('throne.layouts.widget.elements._styles')
    </div>

    <div class="dynamic-elements-box" data-output=".data">
        <span class="btn btn-new" data-type="add"><i class="fas fa-plus-circle"></i> @lang('admin.btn.new')</span>
        <ul class="dynamic-elements">
            @if(isset($data['data']) && is_array($data['data']))
                @foreach($data['data'] as $item)
                    @include('throne.layouts.widget.elements.box_list.add', ['item' => $item])
                @endforeach
            @endif
        </ul>
        <ul class="template hidden">
            @include('throne.layouts.widget.elements.box_list.add', ['item' => []])
            @include('throne.layouts.widget.elements.box_list.option', ['item' => []])
        </ul>
    </div>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'cancel' => route('throne.widget'),
    ])
</form>