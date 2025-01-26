<li class="dynamic-element-add widgetItem box open">
    <div class="handle dd-handle dd3-handle fas"></div>
    <div class="title" data-title="@lang('admin.widget.default_title')">{{isset($item['title']) && !empty($item['title']) ? $item['title'] : trans('admin.widget.default_title')}}</div>
    <div class="widgetItemAction">
        <span class="edit btn btn-warning btn-xs"><i class="far fa-edit"></i></span>
        <span class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></span>
    </div>
    <div class="inside">
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <input type="hidden" data-name="image" value="{{$item['image'] ?? ''}}">
                    <input type="hidden" data-name="image-crop" value="{{$item['image-crop'] ?? ''}}">
                    @include('throne.widgets.slim', ['title'=>trans('admin.widget.counter.element.image'),'ignore'=>empty($item),'imageremove'=>'item_'.(isset($key) ? $key : ''),'width'=>136,'height'=>136,'name'=>'slim','url'=>'widget/counter','data'=>isset($item) ? $item : ''])
                </div>
            </div>
            <div class="col-sm-10">
                <div class="form-group">
                    <label>@lang('admin.widget.counter.element.title')</label>
                    <input type="text" class="form-control input-title" data-name="title" value="{{$item['title'] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label>@lang('admin.widget.counter.element.number')</label>
                    <input type="text" class="form-control" data-name="number" value="{{$item['number'] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
    </div>
</li>