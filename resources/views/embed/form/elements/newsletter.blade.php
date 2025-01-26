@if(!isset($item['hidden']) || (isset($item['hidden']) && $item['required']))
    <div class="form-group {{$errors->first($item['name']) ? 'has-error' : ''}}">
        <input class="checkBoxInput" type="checkbox" name="{{$item['name']}}" id="{{$item['name']}}" {{old($item['name']) ? 'checked' : ''}} {{$item['required'] ? 'required' : ''}}>
        <label for="{{$item['name']}}"><span></span> {!! $item['content'] !!}</label>
        <div class="help-block with-errors">
            {!! $errors->first($item['name'], '<ul class="list-unstyled"><li>:message</li></ul>') !!}
        </div>
    </div>
@endif