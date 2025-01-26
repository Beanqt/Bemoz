<?php
    $crop = isset($data['image_crop'], $data['image']) && !empty($data['image']) ? json_decode($data['image_crop'], true) : null;
    $current_size['width'] = isset($changeSize) ? (isset($crop['size']) ? $crop['size']['width'] : $changeSize['width'][0]) : $width;
    $current_size['height'] = isset($changeSize) ? (isset($crop['size']) ? $crop['size']['height'] : $changeSize['height'][0]) : $height;
?>
@if(isset($title))
    <label for="title">{{$title}}{!! isset($required) ? '<span class="required">*</span>' : '' !!}</label>
@endif
<span class="slim-size">(min: <span class="width">{{$current_size['width']}}</span>x<span class="height">{{$current_size['height']}}</span>px)</span>
<div class="slim{{isset($ignore) && $ignore ? ' ignore' : ''}}"
     data-label="@lang('admin.slim.title')<br><small>@lang('admin.slim.info', ['ext'=>'jpg, jpeg, png'])</small>"
     data-size="{{$current_size['width'].','.$current_size['height']}}"
     data-min-size="{{$current_size['width'].','.$current_size['height']}}"
     data-ratio="{{$current_size['width'].':'.$current_size['height']}}"
     data-post="input, output, actions"
     data-max-file-size="16"
     data-rotate-button="false"
     @if(isset($imageremove) && !empty($imageremove))
        data-did-remove="imageRemoved{{$imageremove !== true ? '_'.$imageremove : ''}}"
     @endif
     data-status-file-size="@lang('admin.slim.error.size')"
     data-status-file-type="@lang('admin.slim.error.type')"
     data-status-no-support="@lang('admin.slim.error.browser')"
     data-button-cancel-label="@lang('admin.slim.cancel')"
     data-button-confirm-label="@lang('admin.slim.confirm')"
     data-status-image-too-small="@lang('admin.slim.small',['size'=>($current_size['width'].'x'.$current_size['height']).'px'])"
     @if(isset($crop['crop']))
        data-crop="{{$crop['crop']}}"
     @endif
>
    @if(isset($data['image']) && !empty($data['image']) && file_exists(public_path('uploads/'.$url.'/'.$data['image'])))
        <img src="/uploads/{{$url}}/{{$data['image']}}" alt=""/>
    @endif
    <input type="file" name="{{$name ?? 'slim'}}" id="image" accept="image/jpg,image/jpeg,image/png"/>

    @if(isset($changeSize))
        <div class="slim-action">
            <i class="far fa-image" data-size="{{$changeSize['width'][0]}}x{{$changeSize['height'][0]}}" data-type="0" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.slim.horizontal')"></i>
            <i class="far fa-file-image" data-size="{{$changeSize['width'][1]}}x{{$changeSize['height'][1]}}" data-type="1" data-toggle="tooltip" data-placement="bottom" title="@lang('admin.slim.vertical')"></i>
        </div>
    @endif
</div>

@if(isset($imageremove) && !empty($imageremove))
    <input type="hidden" name="removeImage{{$imageremove !== true ? '_'.$imageremove : ''}}" class="removeImage{{$imageremove !== true ? '_'.$imageremove : ''}}" value="0">

    <script>
        function imageRemoved{{$imageremove !== true ? '_'.$imageremove : ''}}() {
            $('.removeImage{{$imageremove !== true ? '_'.$imageremove : ''}}').val(1);
        }
    </script>
@endif