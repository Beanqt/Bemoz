<?php
    $path = isset($storage) ? storage_path('/uploads/'.$folder.'/'.$file) : public_path('/uploads/'.$folder.'/'.$file);
?>
<label for="{{$type}}">{{$title ?? ''}}</label>
<div class="custom-file-box {{isset($class) ? $class : 'customFileBox'}}{{isset($data[$type]) && !empty($data[$type]) && file_exists($path) ? ' active' : ''}}" {!! isset($output) ? 'data-output="'.$output.'"' : '' !!} {!! isset($upload) ? 'data-upload="'.$upload.'"' : '' !!} {!! isset($delete) ? (isset($data[$type]) && !empty($data[$type]) && file_exists($path) ? 'data-name="'.$file.'" ' : '').'data-delete="'.$delete.'"' : '' !!}>
    <div class="loader"></div>
    <label>
        <input type="file" {!! $type ? 'name="'.$type.'" id="'.$type.'"' : '' !!} {!! isset($accept) ? 'accept="'.$accept.'"' : ''!!}>
        <i class="fas fa-upload"></i>
    </label>
    <div class="uploaded">
        @if(isset($data[$type]) && !empty($data[$type]) && file_exists($path))
            <div class="custom-file-box-actions">
                <div class="action-inside">
                    @if(!isset($storage))
                        <a class="action-item eye default-link" href="/uploads/{{$folder}}/{{$file}}" target="_blank"><i class="fas fa-eye"></i></a>
                    @endif
                    <span class="action-item custom-file-box-delete"><i class="far fa-trash-alt"></i></span>
                </div>
            </div>
            <div class="preview">
                @if(in_array(fileExtension($file), ['jpeg','jpg','png']))
                    <img class="img-responsive" src="/uploads/{{$folder}}/{{$file}}">
                @else
                    <i class="fas fa-file" aria-hidden="true"></i>
                    <span>.{{fileExtension($file)}}</span>
                @endif
            </div>
            <div class="custom-file-box-info">
                <div class="title">{{$file}}</div>
                <div class="size">{{number_format(filesize($path) /1024/1024, 2, '.','')}}MB</div>
            </div>
        @else
            <div class="custom-file-box-actions">
                <div class="action-inside">
                    <span class="action-item custom-file-box-delete"><i class="far fa-trash-alt"></i></span>
                </div>
            </div>
            <div class="preview"></div>
            <div class="custom-file-box-info">
                <div class="title"></div>
                <div class="size"></div>
            </div>
        @endif
    </div>
</div>