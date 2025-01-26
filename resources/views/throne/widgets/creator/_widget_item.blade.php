<div class="panel box widget-{{$name}}">
    <div class="form-group">
        <label for="shortcodes-widget-{{$name}}">@lang('admin.widget.'.$name.'.title')</label>
        <div class="input-group refresh">
            <span class="input-group-addon widget-refresh" data-type="{{$name}}"><i class="fas fa-sync-alt fa-fw"></i></span>
            <select class="form-control form-custom-select" data-search="true">
                @foreach((isset($current_lang) ? \App\Models\Widget::where('lang', $current_lang['id'])->where('type',$name)->get() : \App\Models\Widget::where('type',$name)->get()) as $key => $item)
                    <option value="{{$item->id}}" {{$key == 0 ? 'selected' : ''}}>{{$item->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="help-block with-errors"></div>
    </div>
    <a href="{{route('throne.widget.new')}}" class="btn btn-primary btn-icon default-link" target="_blank"><i class="fas fa-plus"></i> @lang('admin.btn.new')</a>
    <span class="btn btn-success widget-add btn-icon" data-name="@lang('admin.widget.'.$name.'.title')"><i class="fas fa-cloud-upload-alt"></i> @lang('admin.widget.modules.add')</span>
</div>