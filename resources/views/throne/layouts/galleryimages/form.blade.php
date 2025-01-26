<form method="post" action="{{isset($edit) ? route('throne.galleryimages.edit', [$boss, $edit]) : route('throne.galleryimages.new', $boss)}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="row">
            <div class="col-sm-7">
                <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                    <label for="title">@lang('admin.galleryimages.form.title')<span class="required">*</span></label>
                    <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>

                    <div class="help-block with-errors">
                        {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="alt">@lang('admin.galleryimages.form.alt')</label>
                    <input type="text" class="form-control" name="alt" id="alt" value="{{$data['alt'] ?? ''}}">
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group {{$errors->has('image') ? 'has-error' : ''}}">
                    <label for="title">@lang('admin.galleryimages.form.image')<span class="required">*</span></label>
                    @include('throne.widgets.slim', ['changeSize' => ['width'=>[800, 700],'height'=>[500, 900]],'url'=>'gallery/'.$boss,'data'=>isset($data) ? $data : ''])

                    <div class="help-block with-errors">
                        {!! $errors->first('image', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
    ])
</form>