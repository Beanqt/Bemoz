<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
            <label for="title">@lang('admin.menu.form.title')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group">
            <label for="type">@lang('admin.menu.form.linktype.title')<span class="required">*</span></label>
            <select class="form-control form-custom-select" name="type" id="type">
                <option value="1" {{!isset($data['type']) || (isset($data['type']) && $data['type']==1) ? 'selected' : ''}}>@lang('admin.menu.form.linktype.manual')</option>
                <option value="2" {{isset($data['type']) && $data['type']==2 ? 'selected' : ''}}>@lang('admin.menu.form.linktype.content')</option>

                <optgroup label="@lang('admin.menu.form.linktype.feeds')">
                    <option value="3" {{isset($data['type']) && $data['type']==3 ? 'selected' : ''}}>@lang('admin.menu.form.linktype.feed_category')</option>
                    <option value="5" {{isset($data['type']) && $data['type']==5 ? 'selected' : ''}}>@lang('admin.menu.form.linktype.feed_label')</option>
                    <option value="4" {{isset($data['type']) && $data['type']==4 ? 'selected' : ''}}>@lang('admin.menu.form.linktype.feed_item')</option>
                </optgroup>
            </select>
            <div class="help-block with-errors"></div>
        </div>
        <div class="box-type box-type-1" style="display: {{isset($data['type']) ? ($data['type']==1 ? 'block' : 'none') : 'block'}};">
            <div class="form-group">
                <label for="url">@lang('admin.menu.form.link')</label>
                <input type="text" class="form-control" name="url" id="url" value="{{$data['url'] ?? ''}}">
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="box-type box-type-2" style="display: {{isset($data['type']) && $data['type']==2 ? 'block' : 'none'}};">
            <div class="form-group">
                <label for="page_url">@lang('admin.menu.form.content.link')</label>
                <select class="form-control form-custom-select" name="page_url" id="page_url" data-search="true">
                    <option value="" {{!isset($data['url']) || (isset($data['url']) && $data['url'] == '') ? 'selected' : ''}}>@lang('admin.menu.form.content.choose')</option>
                    @foreach($pages as $page)
                        <option value="{{$page['id']}}" {{isset($data['url']) && $data['url'] == $page['id'] ? 'selected' : ''}}>{{$page['title']}}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="box-type box-type-3" style="display: {{isset($data['type']) && $data['type']==3 ? 'block' : 'none'}};">
            <div class="form-group">
                <label for="feed_category_url">@lang('admin.menu.form.feed_category.link')</label>
                <select class="form-control form-custom-select" name="feed_category_url" id="feed_category_url">
                    <option value="all" {{isset($data['url']) && $data['url'] == 'all' ? 'selected' : ''}}>@lang('admin.menu.form.feed_category.all')</option>
                    @foreach($feed_categories as $item)
                        <option value="{{$item['slug']}}" {{isset($data['url']) && $item['slug'] == $data['url'] ? 'selected' : ''}}>{{$item['title']}}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="box-type box-type-4" style="display: {{isset($data['type']) && $data['type']==4 ? 'block' : 'none'}};">
            <div class="form-group">
                <label for="feed_item_url">@lang('admin.menu.form.feed_items.link')</label>
                <select class="form-control form-custom-select" name="feed_item_url" id="feed_item_url">
                    <option value="" {{!isset($data['url']) || (isset($data['url']) && $data['url'] == '') ? 'selected' : ''}}>@lang('admin.menu.form.feed_items.choose')</option>
                    @foreach($feed_items as $item)
                        <option value="{{$item['id']}}" {{isset($data['url']) && $data['url'] == $item['id'] ? 'selected' : ''}}>{{$item['title']}}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="box-type box-type-5" style="display: {{isset($data['type']) && $data['type']==5 ? 'block' : 'none'}};">
            <div class="form-group">
                <label for="feed_label_url">@lang('admin.menu.form.feed_label.link')</label>
                <select class="form-control form-custom-select" name="feed_label_url" id="feed_label_url" data-placeholder="@lang('admin.menu.form.feed_category.choose')">
                    @foreach($feed_labels as $item)
                        <option value="{{$item['id']}}" {{isset($data['url']) && $item['id'] == $data['url'] ? 'selected' : ''}}>{{$item['title']}}</option>
                    @endforeach
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="external">@lang('admin.menu.form.newpage.title')</label><br>
            <select class="form-control form-custom-select" name="external" id="external">
                <option value="0" {{!isset($data['external']) || (isset($data['external']) && $data['external'] == 0) ? 'selected' : ''}}>@lang('admin.menu.form.newpage.0')</option>
                <option value="1" {{isset($data['external']) && $data['external'] == 1 ? 'selected' : ''}}>@lang('admin.menu.form.newpage.1')</option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="box">
        @include('throne.widgets.public')
        @include('throne.widgets.auth')
    </div>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
        'cancel' => route('throne.menu', $type),
    ])
</form>

<script>
    $(document).ready(function(){
        $('#type').change(function(){
            var type = $(this).val();
            $('.box-type').hide();
            $('.box-type-'+type).show();
        });
    });
</script>