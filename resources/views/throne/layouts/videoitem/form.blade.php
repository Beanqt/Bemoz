<form method="post" enctype="multipart/form-data" action="{{isset($edit) ? route('throne.videoitem.edit', [$boss, $edit]) : route('throne.videoitem.new', $boss)}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
        <label for="title">@lang('admin.videoitem.form.title')<span class="required">*</span></label>
        <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
        <div class="help-block with-errors">
            {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
        </div>
    </div>
    <div class="form-group {{$errors->has('type') ? 'has-error' : ''}}">
        <label for="video_type">@lang('admin.videoitem.form.videotype.title')<span class="required">*</span></label>
        <select class="form-control form-custom-select" name="type" id="video_type" required>
            <option value="1" {{!isset($data['type']) || (isset($data['type']) && $data['type']==1) ? 'selected' : ''}}>@lang('admin.videoitem.form.videotype.youtube')</option>
            <option value="2" {{isset($data['type']) && $data['type']==2 ? 'selected' : ''}}>@lang('admin.videoitem.form.videotype.vimeo')</option>
            <option value="3" {{isset($data['type']) && $data['type']==3 ? 'selected' : ''}}>@lang('admin.videoitem.form.videotype.custom')</option>
            <option value="4" {{isset($data['type']) && $data['type']==4 ? 'selected' : ''}}>@lang('admin.videoitem.form.videotype.gif')</option>
            <option value="5" {{isset($data['type']) && $data['type']==5 ? 'selected' : ''}}>@lang('admin.videoitem.form.videotype.sound')</option>
        </select>
        <div class="help-block with-errors">
            {!! $errors->first('type', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
        </div>
    </div>
    <div class="box-type box-type-1" style="display: {{isset($data['type']) ? ($data['type']==1 ? 'block' : 'none') : 'block'}};">
        <div class="form-group">
            <label for="youtube_id">@lang('admin.videoitem.form.youtube_id')</label>
            <input type="text" class="form-control" name="youtube_id" id="youtube_id" value="{{isset($data['type']) && $data['type']==1 ? (isset($data['youtube_id']) ? $data['youtube_id'] : $data['video_id']) : ''}}">
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="box-type box-type-2" style="display: {{isset($data['type']) && $data['type']==2 ? 'block' : 'none'}};">
        <div class="form-group">
            <label for="vimeo_id">@lang('admin.videoitem.form.vimeo_id')</label>
            <input type="text" class="form-control" name="vimeo_id" id="vimeo_id" value="{{isset($data['type']) && $data['type']==2 ? (isset($data['vimeo_id']) ? $data['vimeo_id'] : $data['video_id']) : ''}}">
            <div class="help-block with-errors"></div>
        </div>
    </div>
    <div class="box-type box-type-3" style="display: {{isset($data['type']) && $data['type']==3 ? 'block' : 'none'}};">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group {{$errors->has('mp4') ? 'has-error' : ''}}">
                    @include('throne.widgets.filebox', ['title' => 'MP4', 'type' => 'mp4', 'size' => (setting('upload_video') ? setting('upload_video') : 100).'MB', 'accept' => '.mp4', 'folder'=>'video/'.$boss, 'file' => (isset($data['mp4']) ? $data['mp4'] : '')])
                    <div class="help-block with-errors">
                        {!! $errors->first('mp4', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group {{$errors->has('webm') ? 'has-error' : ''}}">
                    @include('throne.widgets.filebox', ['title' => 'Webm', 'type' => 'webm', 'size' => (setting('upload_video') ? setting('upload_video') : 100).'MB', 'accept' => '.webm', 'folder'=>'video/'.$boss, 'file' => (isset($data['webm']) ? $data['webm'] : '')])
                    <div class="help-block with-errors">
                        {!! $errors->first('webm', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-type box-type-4" style="display: {{isset($data['type']) && $data['type']==4 ? 'block' : 'none'}};">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group {{$errors->has('gif') ? 'has-error' : ''}}">
                    @include('throne.widgets.filebox', ['title' => 'GIF', 'type' => 'gif', 'folder'=>'video/'.$boss, 'accept' => '.gif', 'file' => (isset($data['video_id']) ? $data['video_id'] : '')])
                    <div class="help-block with-errors">
                        {!! $errors->first('gif', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-type box-type-5" style="display: {{isset($data['type']) && $data['type']==5 ? 'block' : 'none'}};">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group {{$errors->has('sound') ? 'has-error' : ''}}">
                    @include('throne.widgets.filebox', ['title' => 'MP3', 'type' => 'sound', 'folder'=>'video/'.$boss, 'accept' => '.mp3', 'file' => (isset($data['video_id']) ? $data['video_id'] : '')])
                    <div class="help-block with-errors">
                        {!! $errors->first('sound', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-type box-type-3 box-type-5" style="display: {{isset($data['type']) && in_array($data['type'], [3,5]) ? 'block' : 'none'}};">
        <div class="row">
            <div class="col-sm-4">
                <label for="autoplay">@lang('admin.videoitem.form.autoplay')</label><br>
                <label class="switch">
                    <input type="checkbox" name="autoplay" id="autoplay" {{isset($data['autoplay']) && $data['autoplay'] ? 'checked' : ''}}>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="col-sm-4">
                <label for="loop">@lang('admin.videoitem.form.loop')</label><br>
                <label class="switch">
                    <input type="checkbox" name="loop" id="loop" {{isset($data['loop']) && $data['loop'] ? 'checked' : ''}}>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="col-sm-4">
                <label for="mute">@lang('admin.videoitem.form.mute')</label><br>
                <label class="switch">
                    <input type="checkbox" name="mute" id="mute" {{isset($data['mute']) && $data['mute'] ? 'checked' : ''}}>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
        <br>
    </div>
    <div class="row box-type box-type-1 box-type-2 box-type-3" style="display: {{(isset($data['type']) && !in_array($data['type'], [4,5])) || !isset($data['type']) ? 'block' : 'none'}};">
        <div class="col-sm-5">
            <div class="form-group">
                <label for="title">@lang('admin.videoitem.form.image')</label>
                @include('throne.widgets.slim', ['width'=>800,'height'=>400,'url'=>'video/'.$boss,'imageremove'=>true,'data'=>isset($data) ? $data : ''])
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
    $('document').ready(function(){
        $('#video_type').change(function(){
            var type = $(this).val();
            $('.box-type').hide();
            $('.box-type-'+type).show();
        });

        $('.customFileBox').customFileBox();
    });
</script>