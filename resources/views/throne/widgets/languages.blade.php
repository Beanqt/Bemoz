<div class="form-group">
    <label for="lang">@lang('admin.widget.languages.title')<span class="required">*</span></label>
    <select class="form-control" name="lang" id="lang" required>
        <option value="">@lang('admin.widget.languages.choose')</option>
        @foreach($throne_languages as $language)
            @if(isset($data['lang']) && $data['lang']==$language['id'])
                <option value="{{$language['id']}}" selected>{{$language['locale']}}</option>
            @else
                <option value="{{$language['id']}}">{{$language['locale']}}</option>
            @endif
        @endforeach
    </select>
    <div class="help-block with-errors"></div>
</div>