<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group">
            <label for="title">@lang('admin.emails.form.title')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
            <div class="help-block with-errors"></div>
        </div>
    </div>

    <ul class="panelMenu clearfix">
        @foreach($throne_languages as $key => $item)
            <li class="{{$key==0 ? 'active' : ''}}" data-id="{{$item['id']}}">{{$item['name']}}</li>
        @endforeach
    </ul>

    <div class="panels">
        @foreach($throne_languages as $key => $item)
            <div class="panel panel-{{$item['id']}} {{$key==0 ? 'active' : ''}} box">
                <div class="form-group">
                    <label for="subject[{{$item['locale']}}]">@lang('admin.emails.form.subject')</label>
                    <input type="text" class="form-control" name="subject[{{$item['locale']}}]" id="subject[{{$item['locale']}}]" value="{{$data['subject'][$item['locale']] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="content[{{$item['locale']}}]">@lang('admin.emails.form.content')</label>
                    <textarea class="form-control" name="content[{{$item['locale']}}]" id="content[{{$item['locale']}}]" rows="10" cols="80">{{$data['content'][$item['locale']] ?? ''}}</textarea>
                    <script>
                        var editor = CKEDITOR.replace( 'content[{{$item['locale']}}]' );
                        CKFinder.setupCKEditor( editor, { basePath : '/assets/scripts/throne/ckfinder/' } ) ;
                    </script>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">@lang('admin.emails.form.codes')</div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>@lang('admin.emails.form.code')</th>
                        <th>@lang('admin.emails.form.desc')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Emails::$shortcodes[$edit] as $item)
                        <tr>
                            <td>[{{$item}}]</td>
                            <td>@lang('admin.emails.form.shortcode.'.$item)</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'cancel' => route('throne.emails'),
    ])
</form>