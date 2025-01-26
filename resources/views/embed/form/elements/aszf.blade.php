<div class="form-group {{$errors->first($item['name']) ? 'has-error' : ''}}">
    <label class="checkBoxInput">
        <input type="checkbox" name="{{$item['name']}}" id="{{$item['name']}}" {{old($item['name']) ? 'checked' : ''}} required>
        <span></span> {!! $item['content'] !!}
    </label>
    @if($item['required'])
        <span class="required">*</span>
    @endif
    <div class="help-block with-errors">
        {!! $errors->first($item['name'], '<ul class="list-unstyled"><li>:message</li></ul>') !!}
    </div>
</div>

