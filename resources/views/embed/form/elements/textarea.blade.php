<div class="form-group {{$errors->first($item['name']) ? 'has-error' : ''}}">
    @if(!empty($item['label']))
        <label for="{{$item['name']}}">
            {{$item['label']}}{{ $item['required'] ? '*' : '' }}

            @if(!empty($item['help']))
                <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{$item['help']}}"></i>
            @endif
        </label>
    @elseif(!empty($item['help']))
        <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="{{$item['help']}}"></i>
    @endif
    <textarea class="form-control no-resize" name="{{$item['name']}}" id="{{$item['name']}}" {!! !empty($item['regex']) ? '' : (empty($item['min']) ? '' : 'pattern=".{'.$item['min'].',}"') !!} {!! empty($item['max']) ? '' : 'maxlength="'.$item['max'].'"' !!} {!! empty($item['regex']) ? '' : 'pattern="'.$item['regex'].'"' !!} {!! empty($item['placeholder']) ? '' : 'placeholder="'.$item['placeholder'].'"' !!} {{$item['required'] ? 'required' : ''}}>{{old($item['name'])}}</textarea>
    <div class="help-block with-errors">
        {!! $errors->first($item['name'], '<ul class="list-unstyled"><li>:message</li></ul>') !!}
    </div>
</div>