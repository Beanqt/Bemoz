<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="row">
        @if(isset($edit))
            @include('throne.widgets.archive', ['archive_route' => route('throne.events.edit', $edit)])
        @endif
        <div class="col-sm-{{isset($edit) ? 10 : 12}}">
            <div class="box">
                <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                    <label for="title">@lang('admin.events.form.title')<span class="required">*</span></label>
                    <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
                    <div class="help-block with-errors">
                        {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
                <div class="form-group {{$errors->has('slug') ? 'has-error' : ''}}">
                    <label for="slug">@lang('admin.events.form.slug')<span class="required">*</span></label>
                    <input type="text" class="form-control" name="slug" id="slug" value="{{$data['slug'] ?? ''}}" required>
                    <div class="help-block with-errors">
                        {!! $errors->first('slug', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
                <div class="form-group {{$errors->has('place') ? 'has-error' : ''}}">
                    <label for="place">@lang('admin.events.form.place')</label>
                    <input type="text" class="form-control" name="place" id="place" value="{{$data['place'] ?? ''}}">
                    <div class="help-block with-errors">
                        {!! $errors->first('place', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
                <div class="form-group {{$errors->has('short') ? 'has-error' : ''}}">
                    <label for="short">@lang('admin.events.form.short')</label>
                    <textarea class="form-control" name="short" id="short" rows="5" maxlength="255">{{$data['short'] ?? ''}}</textarea>
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

                <div class="row inline-row">
                    <div class="col-sm-6 inline-col">
                        <div class="form-group {{$errors->has('event_start') ? 'has-error' : ''}}">
                            <label for="event_start">@lang('admin.events.form.event_start')<span class="required">*</span></label>
                            <input type="text" class="form-control datetimepicker" name="event_start" id="event_start" value="{{$data['event_start'] ?? ''}}" required>
                            <div class="help-block with-errors">
                                {!! $errors->first('event_start', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 inline-col">
                        <div class="form-group {{$errors->has('event_end') ? 'has-error' : ''}}">
                            <label for="event_end">@lang('admin.events.form.event_end')<span class="required">*</span></label>
                            <input type="text" class="form-control datetimepicker" name="event_end" id="event_end" value="{{$data['event_end'] ?? ''}}" required>
                            <div class="help-block with-errors">
                                {!! $errors->first('event_end', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                @include('throne.widgets.public')
                <div class="form-group">
                    <label for="category">@lang('admin.events.form.category.title')</label>
                    <select class="form-control form-custom-select" name="category" id="category">
                        <option value="" {{!isset($data['category']) || (isset($data['category']) && empty($data['category'])) ? 'selected' : ''}}>@lang('admin.events.form.category.placeholder')</option>
                        @foreach($categories as $item)
                            @if(isset($data['category']) && $item['id'] == $data['category'])
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
                            <label for="title">@lang('admin.events.form.image')<span class="required">*</span></label>
                            @include('throne.widgets.slim', ['width'=>800,'height'=>600,'url'=>'events','data'=>isset($data) ? $data : ''])

                            <div class="help-block with-errors">
                                {!! $errors->first('image', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
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
                'cancel' => route('throne.events'),
            ])
        </div>
    </div>
</form>