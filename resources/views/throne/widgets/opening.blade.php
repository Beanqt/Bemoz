<input type="hidden" class="schedule-json" name="opening" value="{{$data['opening'] ?? ''}}">
<ul class="scheduleWeek box">
    <li class="schedule-header">
        <ul class="schedule-times">
            @for($i = 0; $i < 24; $i++)
                <li>{{$i < 10 ? '0'.$i : $i}}:00</li>
            @endfor
        </ul>
    </li>
    @foreach([trans('admin.day.mon'),trans('admin.day.tue'),trans('admin.day.wed'),trans('admin.day.thu'),trans('admin.day.fri'),trans('admin.day.sat'),trans('admin.day.sun')] as $day)
        <li class="day">
            <span class="schedule-title">{{$day}}</span>
            <ul>
                @for($i = 0; $i < 48; $i++)
                    <li class="schedule-time" data-start-time="{{date('i:s', strtotime(date('2017-01-01 00:00:00').'+'.(30*$i).' second') )}}" data-end-time="{{date('i:s', strtotime(date('2017-01-01 00:00:00').'+'.(30*($i+1)).' second') )}}"></li>
                @endfor
            </ul>
        </li>
    @endforeach
</ul>