<?php
    if(isset($data['option']['markers'])){
        $markers = json_decode($data['option']['markers'], true);
    }
?>

<form method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="submit" name="submit" value="1">
    <input type="hidden" name="removeImage" class="removeImage" value="0">
    <input type="hidden" class="markers-output" name="option[markers]" value="{{$data['option']['markers'] ?? ''}}">
    <div class="box">
        <div class="form-group">
            <label for="title">@lang('admin.widget.map.form.title')<span class="required">*</span></label>
            <input type="text" class="form-control" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
            <div class="help-block with-errors"></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="option[height]">@lang('admin.widget.map.form.height')</label>
                    <input type="number" class="form-control" name="option[height]" id="option[height]" value="{{$data['option']['height'] ?? '400'}}">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="option[width]">@lang('admin.widget.map.form.width.title')</label>
                    <select class="form-control form-custom-select" name="option[width]" id="option[width]">
                        <option value="1" {{!isset($data['option']['width']) || (isset($data['option']['width']) && $data['option']['width']==1) ? 'selected' : ''}}>@lang('admin.widget.map.form.width.full')</option>
                        <option value="2" {{isset($data['option']['width']) && $data['option']['width']==2 ? 'selected' : ''}}>@lang('admin.widget.map.form.width.content')</option>
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lat">@lang('admin.widget.map.form.lat')</label>
                    <input type="text" class="form-control" name="option[lat]" id="lat" value="{{$data['option']['lat'] ?? '47.4962259'}}">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lng">@lang('admin.widget.map.form.lng')</label>
                    <input type="text" class="form-control" name="option[lng]" id="lng" value="{{$data['option']['lng'] ?? '19.0345682'}}">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label for="zoom">@lang('admin.widget.map.form.zoom')</label>
                    <input type="number" class="form-control" name="option[zoom]" id="zoom" value="{{$data['option']['zoom'] ?? '12'}}">
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="style">@lang('admin.widget.map.form.style')</label>
                    <textarea class="form-control" rows="3" name="option[style]" id="style">{{$data['option']['style'] ?? ''}}</textarea>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-sm-2">
                <label for="title">@lang('admin.widget.map.form.image')</label>
                @include('throne.widgets.slim', ['width'=>32,'height'=>32,'name'=>'option[slim]', 'imageremove'=>true,'url'=>'widget/map','data'=>isset($data['option']) ? $data['option'] : ''])
            </div>
        </div>
    </div>

    <div class="relative">
        <div class="address">
            <input type="text" class="form-control" id="address" placeholder="@lang('admin.widget.map.form.search')">
        </div>
    </div>
    <div id="map" style="height: 500px;box-shadow: 0 1px 2px rgba(0,0,0,0.2);border-radius: 3px;overflow: hidden"></div><br>
    <div class="dynamic-elements-box">
        <ul class="markers dynamic-elements row">
            @if(isset($markers) && is_array($markers))
                @foreach($markers as $key => $item)
                    @include('throne.layouts.widget.elements.map.item')
                @endforeach
            @endif
        </ul>
    </div>
    <br>

    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'cancel' => route('throne.widget'),
    ])
</form>
<div class="template hidden">
    @include('throne.layouts.widget.elements.map.item', ['item' => [], 'key' => null])
</div>
<style>
    .markers {
        margin: 0 -1% !important;
    }
    .markers .widgetItem {
        width: 31.333333%;
        margin: 0 1%;
        float: left;
        background: transparent;
    }

    .markers .widgetItem.ui-sortable-helper .inside {
        opacity: 1 !important;
    }
    .markers .widgetItem .inside {
        background: #fff;
        padding: 20px 15px 15px;
    }
    .relative {
        position: relative;
    }
    .address {
        width: 340px;
        position: absolute;
        z-index: 1;
        background: #f7f7f7;
        padding: 10px;
        border-radius: 0 0 3px 3px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.2);
        left: 50%;
        margin-left: -170px;
    }
</style>
<script>
    var map;
    var addressBox = $("#address");
    var markers = [];
    var marker_box = $('.markers');
    var template = $('.template').find('.dynamic-element-marker');

    $(function(){
        app.page.beforeSend(function(){
            var array = [];

            marker_box.find('>li').each(function(){
                var li = $(this);
                array.push(getInputJson(li));
            });

            $('.markers-output').val(JSON.stringify(array));
        });

        addressBox.keypress(function(e){
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                var value = $(this).val();

                if(value){
                    geocodeAddress(value);
                }
            }
        });
        addressBox.blur(function(){
            var value = $(this).val();

            if(value){
                geocodeAddress(value);
            }
        });

        $("#lat, #lng").blur(function(){
            var lat = parseFloat($('#lat').val());
            var lng = parseFloat($('#lng').val());

            if(lat && lng) {
                map.setCenter({
                    lat: !empty(lat) ? lat : 47.4962259,
                    lng: !empty(lng) ? lng : 19.0345682
                });
            }
        });

        $("#zoom").blur(function(){
            map.setZoom(parseInt($(this).val()));
        });
        $("#style").blur(function(){
            if(isJson($(this).val())){
                map.setOptions({styles: JSON.parse($(this).val())});
            }else{
                map.setOptions({styles: []});
            }
        });

        $(document).on('click', '.widgetDelete', function(){
            var key = $(this).parents('li').data('key');

            markers[key].setMap(null);
            marker_box.find('li[data-key='+key+']').remove();
        });
    });

    function initMap() {
        var haightAshbury = {lat: {{$data['option']['lat'] ?? 47.4962259}}, lng: {{$data['option']['lng'] ?? 19.0345682}} };

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: haightAshbury
        });

        map.addListener('click', function(event) {
            addMarker(true, event.latLng);
        });

        @if(isset($markers) && is_array($markers))
            @foreach($markers as $marker)
                addMarker(false, { lat: {{$marker['marker-lat']}}, lng: {{$marker['marker-lng']}} });
            @endforeach
        @endif
    }

    function geocodeAddress(address) {
        var geocoder = new google.maps.Geocoder();

        geocoder.geocode({'address': address}, function(results, status) {
            if (status === 'OK') {
                map.setCenter(results[0].geometry.location);

                addMarker(true, results[0].geometry.location, results[0].formatted_address);

                $("#coordinate").val(results[0].geometry.location.lat() + ", " + results[0].geometry.location.lng());
                addressBox.val('');
            }
        });
    }

    function addMarker(addBox, location, title){
        var key = markers.length;

        markers[key] = new google.maps.Marker({
            map: map,
            position: location
        });

        if(addBox){
            var item = template.clone();

            marker_box.append(item);
            item = marker_box.find('.dynamic-element-marker').last();
            item.attr('data-key', key);
            item.find('.input-marker-lat').val(location.lat());
            item.find('.input-marker-lng').val(location.lng());
            item.find('.input-marker-title').val(title);
        }
    }

    function getInputJson(li){
        var sub_array = { };

        $.each(['marker-lat','marker-lng','marker-title','marker-desc','marker-url'], function(key, index){
            var element = li.find('.input-'+index);
            if(element.length){
                sub_array[index] = element.val();
            }
        });

        return sub_array;
    }

    function imageRemoved() {
        $('.removeImage').val(1);
    }

    if(typeof google == 'undefined'){
        $.getScript("https://maps.googleapis.com/maps/api/js?key={{setting('map')}}&callback=initMap");
    }else{
        initMap();
    }
</script>