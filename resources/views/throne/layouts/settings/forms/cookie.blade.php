<ul class="panelMenu clearfix">
    @foreach($languages as $key => $item)
        <li class="{{$key==0 ? 'active' : ''}}" data-id="{{$item['id']}}">{{$item['name']}}</li>
    @endforeach
</ul>

<div class="panels">
    @foreach($languages as $key => $item)
        <div class="panel panel-{{$item['id']}} {{$key==0 ? 'active' : ''}} box">
            <div class="form-group">
                <label for="data[cookie][{{$item['id']}}][title]">@lang('admin.settings.form.cookie.title')</label>
                <input type="text" class="form-control" name="data[cookie][{{$item['id']}}][title]" id="data[cookie][{{$item['id']}}][title]" value="{{$data['cookie'][$item['id']]['title'] ?? ''}}">
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="data[cookie][{{$item['id']}}][desc]">@lang('admin.settings.form.cookie.desc')</label>
                <textarea class="form-control" name="data[cookie][{{$item['id']}}][desc]" id="data[cookie][{{$item['id']}}][desc]">{{$data['cookie'][$item['id']]['desc'] ?? ''}}</textarea>
                <div class="help-block with-errors"></div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <label for="data[cookie][{{$item['id']}}][btn]">@lang('admin.settings.form.cookie.btn')</label>
                    <input type="text" class="form-control" name="data[cookie][{{$item['id']}}][btn]" id="data[cookie][{{$item['id']}}][btn]" value="{{$data['cookie'][$item['id']]['btn'] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="col-sm-6">
                    <label for="data[cookie][{{$item['id']}}][link]">@lang('admin.settings.form.cookie.link')</label>
                    <input type="text" class="form-control" name="data[cookie][{{$item['id']}}][link]" id="data[cookie][{{$item['id']}}][link]" value="{{$data['cookie'][$item['id']]['link'] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <label for="data[cookie][{{$item['id']}}][ok]">@lang('admin.settings.form.cookie.ok')</label>
                    <input type="text" class="form-control" name="data[cookie][{{$item['id']}}][ok]" id="data[cookie][{{$item['id']}}][ok]" value="{{$data['cookie'][$item['id']]['ok'] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="col-sm-6">
                    <label for="data[cookie][{{$item['id']}}][cancel]">@lang('admin.settings.form.cookie.disable')</label>
                    <input type="text" class="form-control" name="data[cookie][{{$item['id']}}][cancel]" id="data[cookie][{{$item['id']}}][cancel]" value="{{$data['cookie'][$item['id']]['cancel'] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label for="data[cookie][{{$item['id']}}][delete_btn]">@lang('admin.settings.form.cookie.delete_cookie')</label>
                    <input type="text" class="form-control" name="data[cookie][{{$item['id']}}][delete_btn]" id="data[cookie][{{$item['id']}}][delete_btn]" value="{{$data['cookie'][$item['id']]['delete_btn'] ?? ''}}">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
    @endforeach
</div>