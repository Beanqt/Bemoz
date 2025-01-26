<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
            <label for="title">@lang('admin.popup.form.title')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>

        <div class="form-group">
            <label for="pages">@lang('admin.popup.form.pages.title')</label>
            <select class="form-control form-custom-select" name="pages[]" id="pages" data-placeholder="@lang('admin.popup.form.pages.placeholder')" multiple>
                <optgroup label="@lang('admin.popup.form.pages.type.fixed')">
                    <option {{isset($data['pages']) && in_array('all_page',$data['pages']) ? 'selected' : ''}} value="all_page">@lang('admin.popup.form.pages.type.all')</option>
                    <option {{isset($data['pages']) && in_array('home_page',$data['pages']) ? 'selected' : ''}} value="home_page">@lang('admin.popup.form.pages.type.home')</option>
                </optgroup>
                <optgroup label="@lang('admin.popup.form.pages.type.pages')">
                    <option {{isset($data['pages']) && in_array('pages_all',$data['pages']) ? 'selected' : ''}} value="pages_all">@lang('admin.popup.form.pages.type.pages_all')</option>
                    @foreach($pages as $item)
                        <option {{isset($data['pages']) && in_array('page_'.$item['slug'],$data['pages']) ? 'selected' : ''}} value="page_{{$item['slug']}}">{{$item['title']}}</option>
                    @endforeach
                </optgroup>
                <optgroup label="@lang('admin.popup.form.pages.type.feeds')">
                    <option {{isset($data['pages']) && in_array('feeds_all',$data['pages']) ? 'selected' : ''}} value="feeds_all">@lang('admin.popup.form.pages.type.feeds_all')</option>
                    @foreach($feeds as $item)
                        <option {{isset($data['pages']) && in_array('feed_'.$item['slug'],$data['pages']) ? 'selected' : ''}} value="feed_{{$item['slug']}}">{{$item['title']}}</option>
                    @endforeach
                </optgroup>
                <optgroup label="@lang('admin.popup.form.pages.type.labels')">
                    <option {{isset($data['pages']) && in_array('labels_all',$data['pages']) ? 'selected' : ''}} value="labels_all">@lang('admin.popup.form.pages.type.labels_all')</option>
                    @foreach($labels as $item)
                        <option {{isset($data['pages']) && in_array('label_'.$item['slug'],$data['pages']) ? 'selected' : ''}} value="label_{{$item['slug']}}">{{$item['title']}}</option>
                    @endforeach
                </optgroup>
                <optgroup label="@lang('admin.popup.form.pages.type.feed_categories')">
                    <option {{isset($data['pages']) && in_array('feed_categories_all',$data['pages']) ? 'selected' : ''}} value="feed_categories_all">@lang('admin.popup.form.pages.type.feed_categories_all')</option>
                    @foreach($feed_categories as $item)
                        <option {{isset($data['pages']) && in_array('feed_category_'.$item['slug'],$data['pages']) ? 'selected' : ''}} value="feed_category_{{$item['slug']}}">{{$item['title']}}</option>
                    @endforeach
                </optgroup>
            </select>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="type">@lang('admin.popup.form.type.title')</label>
            <select class="form-control form-custom-select" name="type" id="type">
                <option value="1" {{!isset($data['type']) || (isset($data['type']) && $data['type']==1) ? 'selected' : ''}}>@lang('admin.popup.form.type.yes')</option>
                <option value="0" {{isset($data['type']) && $data['type']==0 ? 'selected' : ''}}>@lang('admin.popup.form.type.no')</option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group box-type box-type-0" style="display: {{isset($data['type']) && $data['type']==0 ? 'block' : 'none'}}">
            <label for="second">@lang('admin.popup.form.second')</label>
            <input type="number" class="form-control" name="second" id="second" value="{{$data['second'] ?? ''}}">

            <div class="help-block with-errors">
                {!! $errors->first('second', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
    </div>
    <div class="box">
        <div class="form-group">
            <label for="data[title]">@lang('admin.popup.form.title2')</label>
            <input type="text" class="form-control" name="data[title]" id="data[title]" value="{{$data['data']['title'] ?? ''}}">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="data[content]">@lang('admin.popup.form.content')</label>
            <textarea class="form-control" name="data[content]" id="data[content]">{{$data['data']['content'] ?? ''}}</textarea>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="data[url]">@lang('admin.popup.form.link')</label>
            <input type="text" class="form-control" name="data[url]" id="data[url]" value="{{$data['data']['url'] ?? ''}}">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="data[button]">@lang('admin.popup.form.button')</label>
            <input type="text" class="form-control" name="data[button]" id="data[button]" value="{{$data['data']['button'] ?? ''}}">
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="data[target]">@lang('admin.popup.form.target.title')</label>
            <select class="form-control form-custom-select" name="data[target]" id="data[target]">
                <option value="0" {{!isset($data['data']['target']) || (isset($data['data']['target']) && $data['data']['target']==0) ? 'selected' : ''}}>@lang('admin.popup.form.target.self')</option>
                <option value="1" {{isset($data['data']['target']) && $data['data']['target']==1 ? 'selected' : ''}}>@lang('admin.popup.form.target.new')</option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="box">
        @include('throne.widgets.public')

        <div class="form-group">
            <label for="main_type">@lang('admin.popup.form.main_type.title')</label>
            <select class="form-control form-custom-select" name="main_type" id="main_type">
                <option value="0" {{!isset($data['image']) || (isset($data['image']) && empty($data['image'])) ? 'selected' : ''}}>@lang('admin.popup.form.main_type.0')</option>
                <option value="1" {{isset($data['image']) && !empty($data['image']) ? 'selected' : ''}}>@lang('admin.popup.form.main_type.1')</option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group main-type main-type-1 {{$errors->has('image') ? 'has-error' : ''}}" style="display: {{isset($data['image']) && !empty($data['image']) ? 'block' : 'none'}}">
            <label for="title">@lang('admin.popup.form.image')</label>
            @include('throne.widgets.slim', ['width'=>1170,'height'=>800,'url'=>'popup','data'=>isset($data) ? $data : ''])

            <div class="help-block with-errors">
                {!! $errors->first('image', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
    </div>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
        'cancel' => route('throne.popup'),
    ])
</form>
<script>
    $('#type').change(function(){
        var type = $(this).val();

        $('.box-type').slideUp(200);
        $('.box-type-'+type).slideDown(200);
    });
    $('#main_type').change(function(){
        var type = $(this).val();

        $('.main-type').slideUp(200);
        $('.main-type-'+type).slideDown(200);
    });
</script>