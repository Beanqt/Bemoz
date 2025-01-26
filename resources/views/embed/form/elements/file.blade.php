<div class="form-group {{$errors->first($item['name']) ? 'has-error' : ''}}">
    @if(!empty($item['label']))
        <label>
            {{$item['label']}}{{ $item['required'] ? '*' : '' }}

            @if(!empty($item['help']))
                <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{$item['help']}}"></i>
            @endif
        </label>
    @elseif(!empty($item['help']))
        <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{$item['help']}}"></i>
    @endif
    <br>
    <input type="file" class="customFileBox" data-filesize="{{$item['max_size'] ?? 3}}" data-filesize-error="@lang('public.alerts.max_filesize', ['s' => isset($item['max_size']) ? $item['max_size'] : 3])" data-maxfile="{{$item['max'] ?? 1}}" data-maxfile-error="@lang('public.alerts.max_file', ['s' => isset($item['max']) ? $item['max'] : 1])" name="{{$item['name']}}{{isset($item['max']) && $item['max'] > 1 ? '[]' : ''}}" id="{{$item['name']}}" {{isset($item['max']) && $item['max'] > 1 ? 'multiple' : ''}} {{$item['required'] ? 'required' : ''}} accept="{{isset($item['extension']) ? '.'.str_replace(',', ',.',$item['extension']) : '.jpg,.png,.doc,.pdf'}}">
    <label for="{{$item['name']}}"><i class="fa fas fa-cloud-upload-alt"></i><span>@lang('public.embed.filebox.title')</span></label>
    <div class="help-block with-errors">
        {!! $errors->first($item['name'], '<ul class="list-unstyled"><li>:message</li></ul>') !!}
    </div>
</div>