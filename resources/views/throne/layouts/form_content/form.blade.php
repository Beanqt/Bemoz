<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('type') ? 'has-error' : ''}}">
            <label for="type">@lang('admin.form_content.form.type.title')<span class="required">*</span></label>
            <select name="type" id="type" class="form-control form-custom-select" required>
                <option value="1" {{!isset($data['type']) || (isset($data['type']) && $data['type']==1) ? 'selected' : ''}}>@lang('admin.form_content.form.type.1')</option>
                <option value="2" {{isset($data['type']) && $data['type']==2 ? 'selected' : ''}}>@lang('admin.form_content.form.type.2')</option>
                <option value="3" {{isset($data['type']) && $data['type']==3 ? 'selected' : ''}}>@lang('admin.form_content.form.type.3')</option>
            </select>
            <div class="help-block with-errors">
                {!! $errors->first('type', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="types type-1 type-2" style="display: {{!isset($data['type']) || (isset($data['type']) && in_array($data['type'],[1,2])) ? 'block' : 'none'}}">
            <div class="form-group">
                <label for="subject">@lang('admin.form_content.form.subject')</label>
                <input type="text" class="form-control" name="subject" id="subject" value="{{$data['subject'] ?? ''}}">
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="types type-1" style="display: {{!isset($data['type']) || (isset($data['type']) && $data['type'] == 1) ? 'block' : 'none'}}">
            <div class="form-group">
                <label for="emails">@lang('admin.form_content.form.emails')</label>
                <input type="text" class="form-control" name="emails" id="emails" value="{{$data['emails'] ?? ''}}">
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
    <div class="widget-box" data-sortable="false">
        <div class="form-group">
            <label for="content">@lang('admin.fixedcontent.form.content')</label>
            <textarea class="form-control" name="content" id="content" rows="10" cols="80">{{$data['content'] ?? ''}}</textarea>
            <script>
                var editor = CKEDITOR.replace( 'content' );
                CKFinder.setupCKEditor( editor, { basePath : '/assets/scripts/throne/ckfinder/' } ) ;
            </script>
            <div class="help-block with-errors"></div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">@lang('admin.form_content.form.codes')</div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>@lang('admin.form_content.form.code')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($form['json'] as $item)
                        @if(isset($item['grids']))
                            @foreach($item['grids'][0]['grid'] as $grid)
                                @if(isset($grid['type']) && !in_array($grid['type'], ['html','aszf','newsletter','button','file']))
                                    <tr>
                                        <td>[{{$grid['name']}}]</td>
                                    </tr>
                                @endif
                            @endforeach
                            @foreach($item['grids'][1]['grid'] as $grid)
                                @if(isset($grid['type']) && !in_array($grid['type'], ['html','aszf','newsletter','button','file']))
                                    <tr>
                                        <td>[{{$grid['name']}}]</td>
                                    </tr>
                                @endif
                            @endforeach
                        @elseif(isset($item['type']) && !in_array($item['type'], ['html','aszf','newsletter','button','file']))
                            <tr>
                                <td>[{{$item['name']}}]</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
    ])
</form>
<script>
    $(document).ready(function(){
        var select = $('#type');

        select.change(function(){
            var value = $(this).val();

            $('.types').hide();
            $('.type-'+value).show();
        });
    });
</script>