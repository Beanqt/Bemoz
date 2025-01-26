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
    <br>
    @foreach($item['options'] as $key => $option)
        <label class="checkBoxInput">
            <input type="checkbox" name="{{$item['name']}}[]" id="{{$key}}-{{$item['name']}}" value="{{empty($option['value']) ? $option['title'] : $option['value']}}" {{old($item['name']) == (empty($option['value']) ? $option['title'] : $option['value']) ? 'checked' : ''}} {{$item['required'] ? 'required' : ''}}>
            <span></span> {{$option['title']}}
        </label>
    @endforeach
    <div class="help-block with-errors">
        {!! $errors->first($item['name'], '<ul class="list-unstyled"><li>:message</li></ul>') !!}
    </div>
</div>


