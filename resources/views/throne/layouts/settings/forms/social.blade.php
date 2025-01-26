<ul class="sortable mini-sortable" data-nested="0">
    @foreach((isset($data['social']) ? $data['social'] : [])+['facebook'=>'', 'youtube'=>'', 'instagram'=>'', 'linkedin'=>'', 'google'=>'', 'twitter'=>''] as $key => $item)
        <li class="box dd-item widgetItem {{$key}} {{isset($data['social_'.$key]) && !empty($data['social_'.$key]) ? 'active' : ''}}">
            <div class="handle dd3-handle fas"></div>

            <label for="data[social][{{$key}}]">@lang('admin.settings.form.'.$key)</label>
            <input type="text" class="form-control" name="data[social][{{$key}}]" id="data[social][{{$key}}]" value="{{$item}}">
        </li>
    @endforeach
</ul>
<script>
    $('.sortable').sortable({
        handle: ".handle",
        items: "> .widgetItem"
    }).disableSelection();
</script>
<br>
<style>
    .sortable {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .dd-item {
        padding: 15px;
    }
    .dd-handle {
        position: absolute;
        left: -17px;
        top: -1px;
        background: #cccccc;
        color: #343a4a;
        width: 17px;
        text-align: center;
        border-radius: 3px 0 0 3px;
        cursor: pointer;
    }
    .dd-placeholder {
        margin-bottom: 20px;
        padding: 15px;
    }
    .widgetMove {
        background: #5cb85c;
        color: #fff;
    }
</style>