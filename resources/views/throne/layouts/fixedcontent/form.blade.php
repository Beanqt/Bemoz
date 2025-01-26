<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <ul class="panelMenu clearfix">
        @foreach($throne_languages as $key => $item)
            <li class="{{$key==0 ? 'active' : ''}}" data-id="{{$item['id']}}">{{$item['name']}}</li>
        @endforeach
    </ul>

    <div class="panels">
        @foreach($throne_languages as $key => $item)
            <div class="panel panel-{{$item['id']}} {{$key==0 ? 'active' : ''}} box">
                <div class="form-group {{$errors->has('title.'.$item['locale']) ? 'has-error' : ''}}">
                    <label for="title[{{$item['locale']}}]">@lang('admin.fixedcontent.form.title')</label>
                    <input type="text" class="form-control" name="title[{{$item['locale']}}]" id="title[{{$item['locale']}}]" value="{{$data['title'][$item['locale']] ?? ''}}">
                    <div class="help-block with-errors">{!! $errors->first('title.'.$item['locale'], '<ul class="list-unstyled"><li>:message</li></ul>') !!}</div>
                </div>

                <div class="widget-box" data-sortable="false">
                    @include('throne.widgets.creator.loader', ['without_sortable' => true, 'widgets' => [
                        'id'=>1,
                        'button'=>true,
                    ]])
                    <div class="form-group">
                        <label for="content[{{$item['locale']}}]">@lang('admin.fixedcontent.form.content')</label>
                        <textarea class="form-control" name="content[{{$item['locale']}}]" id="content[{{$item['locale']}}]" rows="10" cols="80">{{$data['content'][$item['locale']] ?? ''}}</textarea>
                        <script>
                            var editor = CKEDITOR.replace( 'content[{{$item['locale']}}]' );
                            CKFinder.setupCKEditor( editor, { basePath : '/assets/scripts/throne/ckfinder/' } ) ;
                        </script>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="seo_title[{{$item['locale']}}]">@lang('admin.widget.seo.title')</label>
                    <input type="text" class="form-control" name="seo_title[{{$item['locale']}}]" id="seo_title[{{$item['locale']}}]" value="{{$data['seo_title'][$item['locale']] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="seo_keywords[{{$item['locale']}}]">@lang('admin.widget.seo.keywords')</label>
                    <input type="text" class="form-control" name="seo_keywords[{{$item['locale']}}]" id="seo_keywords[{{$item['locale']}}]" value="{{$data['seo_keywords'][$item['locale']] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="seo_desc[{{$item['locale']}}]">@lang('admin.widget.seo.desc') <small>@lang('admin.widget.seo.max')</small></label>
                    <textarea class="form-control" maxlength="160" name="seo_desc[{{$item['locale']}}]" id="seo_desc[{{$item['locale']}}]">{{$data['seo_desc'][$item['locale']] ?? ''}}</textarea>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        @endforeach
    </div>
    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'cancel' => route('throne.fixedcontent'),
    ])
</form>