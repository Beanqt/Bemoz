<div class="row inline-row datetimerange">
    <div class="col-sm-6 inline-col">
        <div class="form-group {{$errors->has('public_at') ? 'has-error' : ''}}">
            <label for="public_at">@lang('admin.widget.public.title')<span class="required">*</span></label>
            <input type="text" class="form-control datetimepickermin" autocomplete="off" name="public_at" id="public_at" value="{{isset($data['public_at']) && $data['public_at'] && $data['public_at'] != '0000-00-00 00:00:00' ? $data['public_at'] : date('Y-m-d H:i:s')}}" required>

            <div class="help-block with-errors">
                {!! $errors->first('public_at', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
    </div>
    <div class="col-sm-6 inline-col">
        <div class="form-group {{$errors->has('finish_at') ? 'has-error' : ''}}">
            <label for="finish_at">@lang('admin.widget.public.title2')</label>
            <input type="text" class="form-control datetimepickermax" autocomplete="off" name="finish_at" id="finish_at" value="{{$data['finish_at'] ?? ''}}">

            <div class="help-block with-errors">
                {!! $errors->first('finish_at', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
    </div>
</div>