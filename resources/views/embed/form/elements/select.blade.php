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
    <select class="form-control form-custom-select" name="{{$item['name']}}" id="{{$item['name']}}" {{$item['required'] ? 'required' : ''}}>
        @if(!empty($item['placeholder']))
            <option value="">{{$item['placeholder']}}</option>
        @endif
        @foreach($item['options'] as $option)
            <option value="{{empty($option['value']) ? $option['title'] : $option['value']}}" {{old($item['name']) == (empty($option['value']) ? $option['title'] : $option['value']) ? 'selected' : ''}}>{{$option['title'] ?? ''}}</option>
        @endforeach
    </select>
    <div class="help-block with-errors">
        {!! $errors->first($item['name'], '<ul class="list-unstyled"><li>:message</li></ul>') !!}
    </div>
</div>