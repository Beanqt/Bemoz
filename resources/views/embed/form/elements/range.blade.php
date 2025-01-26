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
    <div class="range-box">
        <input type="range" class="range" name="{{$item['name']}}" id="{{$item['name']}}" min="{{empty($item['min']) ? 1 : $item['min']}}" max="{{empty($item['max']) ? 2 : $item['max']}}" step="{{empty($item['step']) ? 1 : $item['step']}}" value="{{old($item['name']) ?? 1}}" {{$item['required'] ? 'required' : ''}}>
        <div class="range-min"><span class="range-current">1</span>/{{empty($item['max']) ? 1 : $item['max']}}</div>
    </div>
    <div class="help-block with-errors">
        {!! $errors->first($item['name'], '<ul class="list-unstyled"><li>:message</li></ul>') !!}
    </div>
</div>