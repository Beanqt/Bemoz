@extends('throne.partials.master')

@section('content')
    <div class="container">
        <h1 class="page-header">@lang('admin.dashboard.title')</h1>
        <div class="filter">
            <form method="get" class="filter-form">
                <div class="box">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" autocomplete="off" class="form-control datetimepicker" data-date-format="YYYY-MM-DD" name="start" id="start" placeholder="@lang('admin.dashboard.start')" value="{{$start}}">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" autocomplete="off" class="form-control datetimepicker" data-date-format="YYYY-MM-DD" name="end" id="end" placeholder="@lang('admin.dashboard.end')" value="{{$end}}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="relative stat-main-box">
            <div class="loader"></div>
            <div class="staticBoxs row">
                <div class="staticItem col-lg-2 col-sm-4 col-xs-12">
                    <div class="box helpItem" data-help="onlineUser">
                        <div class="huge useronline">{{$active}}</div>
                        <div>@lang('admin.dashboard.active')</div>
                    </div>
                </div>
                <div class="staticItem col-lg-2 col-sm-4 col-xs-12">
                    <div class="box helpItem" data-help="newUser">
                        <div class="huge">{{$new_users}}</div>
                        <div>@lang('admin.dashboard.new_users')</div>
                    </div>
                </div>
                <div class="staticItem col-lg-2 col-sm-4 col-xs-12">
                    <div class="box helpItem" data-help="returnUser">
                        <div class="huge">{{$return_users}}</div>
                        <div>@lang('admin.dashboard.return_users')</div>
                    </div>
                </div>
                <div class="staticItem col-lg-2 col-sm-4 col-xs-12">
                    <div class="box helpItem" data-help="allUser">
                        <div class="huge">{{$all_users}}</div>
                        <div>@lang('admin.dashboard.all_users')</div>
                    </div>
                </div>
                <div class="staticItem col-lg-2 col-sm-4 col-xs-12">
                    <div class="box helpItem" data-help="allShow">
                        <div class="huge">{{$all_show}}</div>
                        <div>@lang('admin.dashboard.all_show')</div>
                    </div>
                </div>
            </div>
            <div class="chartBox">
                <div class="box helpItem" data-help="userChart" data-position="top">
                    <h3>@lang('admin.dashboard.chart.new_user')</h3>
                    <canvas id="user" width="500" height="100"></canvas>
                    <script>
                        var ctx = document.getElementById("user");
                        var userChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ["{!! implode('","',array_keys($userChart)) !!}"],
                                datasets: [{
                                    label: "@lang('admin.dashboard.chart.new_user')",
                                    borderWidth: 1,
                                    lineTension: 0.1,
                                    backgroundColor: "rgba(51, 122, 183, 0.32)",
                                    borderColor: "#337ab7",
                                    borderCapStyle: 'butt',
                                    borderDash: [],
                                    borderDashOffset: 0.0,
                                    borderJoinStyle: 'miter',
                                    pointBorderColor: "#fff",
                                    pointBackgroundColor: "#103B61",
                                    pointBorderWidth: 1,
                                    pointHoverRadius: 5,
                                    pointHoverBackgroundColor: "#fff",
                                    pointHoverBorderColor: "rgba(6, 197, 172, 1)",
                                    pointHoverBorderWidth: 2,
                                    pointRadius: 1,
                                    pointHitRadius: 10,

                                    data : [{{implode(',',$userChart)}}]
                                }]
                            },
                            options: {
                                legend: {
                                    display: false,
                                }
                            }
                        });
                    </script>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="chartBox">
                        <div class="box helpItem" data-help="device" data-position="top">
                            <h3>@lang('admin.dashboard.chart.device')</h3>

                            <ul class="staticUl">
                                @if(isset($device['computer']))
                                    <li>
                                        <span class="number">{{$device['computer']}}</span>
                                        <div class="title">@lang('admin.dashboard.device.computer')</div>
                                        <div class="percentBox"><span class="percent-number">{{getPercent($device['computer'], $all_devices, true)}}%</span><span class="percent" style="width: {{getPercent($device['computer'], $all_devices)}}%"></span></div>
                                    </li>
                                @endif
                                @if(isset($device['tablet']))
                                    <li>
                                        <span class="number">{{$device['tablet']}}</span>
                                        <div class="title">@lang('admin.dashboard.device.tablet')</div>
                                        <div class="percentBox"><span class="percent-number">{{getPercent($device['tablet'], $all_devices, true)}}%</span><span class="percent" style="width: {{getPercent($device['tablet'], $all_devices)}}%"></span></div>
                                    </li>
                                @endif
                                @if(isset($device['mobil']))
                                    <li>
                                        <span class="number">{{$device['mobil']}}</span>
                                        <div class="title">@lang('admin.dashboard.device.mobile')</div>
                                        <div class="percentBox"><span class="percent-number">{{getPercent($device['mobil'], $all_devices, true)}}%</span><span class="percent" style="width: {{getPercent($device['mobil'], $all_devices)}}%"></span></div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="chartBox">
                        <div class="box helpItem" data-help="browser" data-position="top">
                            <h3>@lang('admin.dashboard.chart.browser')</h3>
                            <ul class="staticUl">
                                @foreach($browsers as $browser)
                                    <li>
                                        <span class="number">{{$browser->counted}}</span>
                                        <div class="title">{{isset($browser_type[$browser->browser]) ? $browser_type[$browser->browser] : 'Egyéb'}}</div>
                                        <div class="percentBox"><span class="percent-number">{{getPercent($browser->counted, $all_show, true)}}%</span><span class="percent" style="width: {{getPercent($browser->counted, $all_show)}}%"></span></div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chartBox">
                        <div class="box helpItem" data-help="top10" data-position="top">
                            <h3>@lang('admin.dashboard.chart.top')</h3>
                            <ul class="staticUl">
                                @foreach($pages as $page)
                                    <li>
                                        <span class="number">{{$page['counted']}}</span>
                                        <div class="title">{{$page['page']}}</div>
                                        <div class="percentBox"><span class="percent-number">{{getPercent($page['counted'], $all_show, true)}}%</span><span class="percent" style="width: {{getPercent($page['counted'], $all_show)}}%"></span></div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var time;

        app.page.mounted = function(){
            var startBox = $('#start');
            var endBox = $('#end');
            var start = startBox.val();
            var end = endBox.val();

            time = setInterval(function(){
                $.getJSON(route('online.users')).done(function(data){
                    $('.useronline').text(data.user);
                }).fail(function(){
                    clearInterval(time);
                });
            }, 8000);

            startBox.blur(function(){
                if(start != $(this).val()){
                    $('.stat-main-box').find('.loader').addClass('active');
                    $('.filter-form').submit();

                    start = $(this).val();
                }
            });
            endBox.blur(function(){
                if(end != $(this).val()) {
                    $('.stat-main-box').find('.loader').addClass('active');
                    $('.filter-form').submit();

                    end = $(this).val();
                }
            });
        };

        app.page.beforeDelete = function(){
            clearInterval(time);
        };
    </script>
@stop