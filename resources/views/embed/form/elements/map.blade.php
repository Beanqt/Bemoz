@if(setting('map'))
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
        <div class="help-block with-errors">
            {!! $errors->first($item['name'], '<ul class="list-unstyled"><li>:message</li></ul>') !!}
        </div>
        <input type="text" class="hidden" name="{{$item['name']}}" id="{{$item['name']}}" value="{{old($item['name'])}}" {{$item['required'] ? 'required' : ''}}>

        <div class="map" data-edited="true" {!! isset($item['height']) && !empty($item['height']) ? 'style="height: '.$item['height'].'px;"' : '' !!} data-style="{{ isset($item['style']) ? preg_replace('/\s+/', '', $item['style']) : '' }}" data-lat="{{$item['lat'] ?? ''}}" data-lng="{{$item['lng'] ?? ''}}" data-zoom="{{$item['zoom'] ?? ''}}">
            <div class="loader active"></div>
        </div>
    </div>
@endif