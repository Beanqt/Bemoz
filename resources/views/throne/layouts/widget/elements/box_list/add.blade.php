<li class="dynamic-element-add widgetItem box open">
    <div class="handle dd-handle dd3-handle fas"></div>
    <div class="title" data-title="@lang('admin.widget.default_title')">{{isset($item['title']) && !empty($item['title']) ? $item['title'] : trans('admin.widget.default_title')}}</div>
    <div class="widgetItemAction">
        <span class="edit btn btn-warning btn-xs"><i class="far fa-edit"></i></span>
        <span class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt"></i></span>
    </div>
    <div class="inside">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>@lang('admin.widget.box_list.element.active')</label><br>
                    <label class="switch">
                        <input type="checkbox" data-name="active" {{isset($item['active']) && $item['active'] ? 'checked' : ''}}>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div class="form-group">
                    <input type="hidden" data-name="image" value="{{$item['image'] ?? ''}}">
                    <input type="hidden" data-name="image-crop" value="{{$item['image-crop'] ?? ''}}">
                    @include('throne.widgets.slim', ['title'=>trans('admin.widget.box_list.element.image'),'ignore' => empty($item),'imageremove'=>'item_'.(isset($key) ? $key : ''),'width'=>800,'height'=>530,'name'=>'slim','url'=>'widget/box_list','data'=>isset($item) ? $item : ''])
                </div>
            </div>
            <div class="col-sm-8">
                <div class="widgetInsideBox">
                    <div class="field-main-title">
                        @lang('admin.widget.box_list.element.options.header')
                        <div class="widgetItemAction">
                            <span class="btn btn-primary new-option btn-xs"><i class="fas fa-plus"></i></span>
                        </div>
                    </div>
                    <ul class="options widgetInsideContent">
                        @if(isset($item['options']))
                            @foreach($item['options'] as $key => $option)
                                @include('throne.layouts.widget.elements.box_list.option', ['item'=>$option])
                            @endforeach
                        @else
                            @include('throne.layouts.widget.elements.box_list.option', ['item' => []])
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</li>