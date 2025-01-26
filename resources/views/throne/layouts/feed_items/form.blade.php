<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="row">
        @if(isset($edit))
            @include('throne.widgets.archive', ['archive_route' => route('throne.feed_items.edit', $edit)])
        @endif
        <div class="col-sm-{{isset($edit) ? 10 : 12}}">
            <div class="box">
                <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                    <label for="title">@lang('admin.feed_items.form.title')<span class="required">*</span></label>
                    <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
                    <div class="help-block with-errors">
                        {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
                <div class="form-group {{$errors->has('slug') ? 'has-error' : ''}}">
                    <label for="slug">@lang('admin.feed_items.form.slug')<span class="required">*</span></label>
                    <input type="text" class="form-control" name="slug" id="slug" value="{{$data['slug'] ?? ''}}" required>
                    <div class="help-block with-errors">
                        {!! $errors->first('slug', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
                <div class="form-group {{$errors->has('short') ? 'has-error' : ''}}">
                    <label for="short">@lang('admin.feed_items.form.short')<span class="required">*</span></label>
                    <textarea class="form-control" name="short" id="short" maxlength="255" rows="4" required>{{$data['short'] ?? ''}}</textarea>
                    <div class="help-block with-errors">
                        {!! $errors->first('short', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
            </div>

            @include('throne.widgets.creator.loader', ['name' => 'layout', 'widgets' => [
                'id'=>1,
                'grid'=>true,
                'content'=>true,
                'button'=>true,
                'gallery'=>true,
                'videos'=>true,
                'documents'=>true,
                'forms'=>true,
                'widget_box_list'=>true,
                'widget_category'=>true,
                'widget_counter'=>true,
                'widget_parallax'=>true,
                'widget_tab'=>true,
                'widget_faq'=>true,
                'widget_map'=>true,
            ]])

            <div class="box">
                @include('throne.widgets.template')
                @include('throne.widgets.public')
                <div class="form-group">
                    <label for="category">@lang('admin.feed_items.form.category.title')</label>
                    <select class="form-control form-custom-select" name="category" id="category">
                        <option value="" {{!isset($data['category']) || (isset($data['category']) && empty($data['category'])) ? 'selected' : ''}}>@lang('admin.feed_items.form.category.placeholder')</option>
                        @foreach($categories as $item)
                            @if(isset($data['category']) && $item['id'] == $data['category'])
                                <option value="{{$item['id']}}" selected>{{$item['title']}}</option>
                            @else
                                <option value="{{$item['id']}}">{{$item['title']}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="label">@lang('admin.feed_items.form.label.title')</label>
                    <select class="form-control form-custom-select" name="label[]" id="label" data-placeholder="@lang('admin.feed_items.form.label.placeholder')" multiple>
                        @foreach($labels as $item)
                            @if(isset($data['label']) && in_array($item['id'], $data['label']))
                                <option value="{{$item['id']}}" selected>{{$item['title']}}</option>
                            @else
                                <option value="{{$item['id']}}">{{$item['title']}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                @include('throne.widgets.auth')
            </div>
            <div class="box">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group {{$errors->has('image') ? 'has-error' : ''}}">
                            @include('throne.widgets.slim', [
                                'title' => trans('admin.slider.form.image'),
                                'required' => true,
                                'width' => 700,
                                'height' => 700,
                                'url' => 'feed_items',
                                'data' => isset($data) ? $data : ''
                            ])

                            <div class="help-block with-errors">
                                {!! $errors->first('image', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group {{$errors->has('bg_image') ? 'has-error' : ''}}">
                            @include('throne.widgets.slim', [
                                'title' => trans('admin.slider.form.bgimage'),
                                'width' => 1920,
                                'height' => 344,
                                'name' => 'bg_image',
                                'url' => 'feed_items/bg/',
                                'imageremove' => true,
                                'data' => ['image'=>isset($data['bg_image']) ? $data['bg_image'] : '', 'image_crop' => isset($data['bg_image_crop']) ? $data['bg_image_crop'] : '']
                            ])

                            <div class="help-block with-errors">
                                {!! $errors->first('bg_image', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                @include('throne.widgets.seo')
            </div>

            @include('throne.widgets.actions', [
                'save' => true,
                'saveClose' => true,
                'saveNew' => true,
                'saveArchived' => true,
                'saveCloseArchived' => true,
                'cancel' => route('throne.feed_items'),
                'formShow' => true,
            ])
        </div>
    </div>
</form>
