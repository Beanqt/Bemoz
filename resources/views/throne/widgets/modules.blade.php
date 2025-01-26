<div class="loader"></div>
<div class="form-group">
    <label for="shortcodes">@lang('admin.widget.modules.title')</label>
    <select class="form-control form-custom-select selector">
        <option value="" selected>@lang('admin.widget.modules.choose')</option>
        <option value="protect-email">@lang('admin.widget.modules.element.email')</option>
        @if(isset($content))
            <option value="content">@lang('admin.widget.modules.element.content')</option>
        @endif
        @if(isset($button))
            <option value="button">@lang('admin.widget.modules.element.button')</option>
        @endif
        @if(isset($grid))
            <option value="grid">@lang('admin.widget.modules.element.grid')</option>
        @endif
        @if(isset($forms))
            <option value="forms">@lang('admin.widget.modules.element.forms')</option>
        @endif
        @if(isset($gallery) || isset($documents) || isset($videos))
            <optgroup label="@lang('admin.mediatar.title')">
                @if(isset($gallery))
                    <option value="gallery">@lang('admin.widget.modules.element.gallery.title')</option>
                @endif
                @if(isset($documents))
                    <option value="documents">@lang('admin.widget.modules.element.document')</option>
                @endif
                @if(isset($videos))
                    <option value="video">@lang('admin.widget.modules.element.video')</option>
                @endif
            </optgroup>
        @endif
        @if(isset($widget_category) || isset($widget_box_list) || isset($widget_counter) || isset($widget_parallax) || isset($widget_tab) || isset($widget_faq) || isset($widget_map))
            <optgroup label="@lang('admin.widget.title')">
                @if(isset($widget_box_list))
                    <option value="widget-box_list">@lang('admin.widget.box_list.title')</option>
                @endif
                @if(isset($widget_category))
                    <option value="widget-category">@lang('admin.widget.category.title')</option>
                @endif
                @if(isset($widget_counter))
                    <option value="widget-counter">@lang('admin.widget.counter.title')</option>
                @endif
                @if(isset($widget_parallax))
                    <option value="widget-parallax">@lang('admin.widget.parallax.title')</option>
                @endif
                @if(isset($widget_tab))
                    <option value="widget-tab">@lang('admin.widget.tab.title')</option>
                @endif
                @if(isset($widget_faq))
                    <option value="widget-faq">@lang('admin.widget.faq.title')</option>
                @endif
                @if(isset($widget_map))
                    <option value="widget-map">@lang('admin.widget.map.title')</option>
                @endif
            </optgroup>
        @endif
    </select>
</div>
<div class="panels">
    <div class="panel box protect-email">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="shortcode-email">@lang('admin.widget.modules.boxs.email.email')</label>
                    <input type="text" class="form-control" name="shortcode-protect-email" id="shortcode-email">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="shortcode-email-text">@lang('admin.widget.modules.boxs.email.text')</label>
                    <input type="text" class="form-control" name="shortcode-protect-email-text" id="shortcode-email-text">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <span class="btn btn-success shortcode-general" data-name="email">@lang('admin.widget.modules.button')</span>
    </div>
    @if(isset($button))
        <div class="panel box button">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="shortcode-button-link">@lang('admin.widget.modules.boxs.button.link')</label>
                        <input type="text" class="form-control" name="shortcode-button-link" id="shortcode-button-link">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="shortcode-button-text">@lang('admin.widget.modules.boxs.button.text')</label>
                        <input type="text" class="form-control" name="shortcode-button-text" id="shortcode-button-text">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="shortcode-button-open">@lang('admin.widget.modules.boxs.button.target.title')</label>
                        <select class="form-control form-custom-select" name="shortcode-button-open" id="shortcode-button-open">
                            <option value="self" selected>@lang('admin.widget.modules.boxs.button.target.self')</option>
                            <option value="new">@lang('admin.widget.modules.boxs.button.target.new')</option>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="shortcode-button-event">@lang('admin.widget.modules.boxs.button.ga.event')</label>
                        <input type="text" class="form-control" name="shortcode-button-event" id="shortcode-button-event">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <span class="btn btn-success shortcode-general" data-name="button">@lang('admin.widget.modules.button')</span>
        </div>
    @endif
    @if(isset($forms))
        <div class="panel box forms">
            <div class="form-group">
                <label for="shortcodes-forms">@lang('admin.widget.modules.boxs.forms.title')</label>
                <select class="form-control form-custom-select" id="shortcodes-forms">
                    @foreach(\App\Models\Forms::where('lang', $current_lang['id'])->get() as $key => $item)
                        <option value="{{$item->id}}" {{$key == 0 ? 'selected' : ''}}>{{$item->title}}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
            <span class="btn btn-success shortcode-general" data-name="forms">@lang('admin.widget.modules.button')</span>
        </div>
    @endif
    @if(isset($widget_box_list))
        @include('throne.widgets.creator._widget_item', ['name' => 'box_list'])
    @endif
    @if(isset($widget_category))
        @include('throne.widgets.creator._widget_item', ['name' => 'category'])
    @endif
    @if(isset($widget_counter))
        @include('throne.widgets.creator._widget_item', ['name' => 'counter'])
    @endif
    @if(isset($widget_parallax))
        @include('throne.widgets.creator._widget_item', ['name' => 'parallax'])
    @endif
    @if(isset($widget_subscribe))
        @include('throne.widgets.creator._widget_item', ['name' => 'subscribe'])
    @endif
    @if(isset($widget_contact))
        @include('throne.widgets.creator._widget_item', ['name' => 'contact'])
    @endif
    @if(isset($widget_tab))
        @include('throne.widgets.creator._widget_item', ['name' => 'tab'])
    @endif
    @if(isset($widget_faq))
        @include('throne.widgets.creator._widget_item', ['name' => 'faq'])
    @endif
    @if(isset($widget_map))
        @include('throne.widgets.creator._widget_item', ['name' => 'map'])
    @endif
</div>
<ul class="shortcodes-table">
</ul>