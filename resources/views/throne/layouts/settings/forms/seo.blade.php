<ul class="panelMenu clearfix" data-target=".seo-panels">
    @foreach($languages as $key => $item)
        <li class="{{$key==0 ? 'active' : ''}}" data-id="{{$item['id']}}">{{$item['name']}}</li>
    @endforeach
</ul>

<div class="panels seo-panels">
    @foreach($languages as $key => $item)
        <div class="panel panel-{{$item['id']}} {{$key==0 ? 'active' : ''}} box">
            <div class="form-group">
                <label for="data[seo][{{$item['id']}}][title]">@lang('admin.settings.form.seo.title')</label>
                <input type="text" class="form-control" name="data[seo][{{$item['id']}}][title]" id="data[seo][{{$item['id']}}][title]" value="{{$data['seo'][$item['id']]['title'] ?? ''}}">
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="data[seo][{{$item['id']}}][keywords]">@lang('admin.settings.form.seo.keywords')</label>
                <input type="text" class="form-control" name="data[seo][{{$item['id']}}][keywords]" id="data[seo][{{$item['id']}}][keywords]" value="{{$data['seo'][$item['id']]['keywords'] ?? ''}}">
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="data[seo][{{$item['id']}}][desc]">@lang('admin.settings.form.seo.desc') <small>@lang('admin.settings.form.seo.max')</small></label>
                <textarea class="form-control" maxlength="160" name="data[seo][{{$item['id']}}][desc]" id="data[seo][{{$item['id']}}][desc]">{{$data['seo'][$item['id']]['desc'] ?? ''}}</textarea>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    @endforeach
</div>