<form method="post" enctype="multipart/form-data" action="{{isset($edit) ? route('throne.documentitem.edit', [$boss, $edit]) : route('throne.documentitem.new', $boss)}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
            <label for="title">@lang('admin.documentitem.form.title')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group {{$errors->has('file') ? 'has-error' : ''}}">
                    @include('throne.widgets.filebox', ['title' => trans('admin.documentitem.form.file'), 'type' => 'file', 'size' => '500MB', 'folder'=>'documentitem/'.$boss, 'file' => (isset($data['file']) ? $data['file'] : '')])
                    <div class="help-block with-errors">
                        {!! $errors->first('file', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="title">@lang('admin.documentitem.form.image')</label>
                    @include('throne.widgets.slim', ['width'=>640,'height'=>360,'url'=>'documentitem/'.$boss.'/image','imageremove'=>true,'data'=>isset($data) ? $data : ''])
                </div>
            </div>
        </div>
    </div>
    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'saveNew' => true,
    ])
</form>
<script>
    $('.customFileBox').customFileBox();
</script>