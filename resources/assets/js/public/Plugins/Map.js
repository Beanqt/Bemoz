(function($){
    var googleMap = function(container, options){
        this.container = container;
        this.options = options;

        this.init();
    };

    googleMap.prototype = {
        init: function(){
            this.markerJson = !empty(this.container.data('markers')) ? this.container.data('markers') : {};
            this.icon = !empty(this.container.data('icon')) ? this.container.data('icon') : this.options.icon;
            this.zoom = !empty(this.container.data('zoom')) ? this.container.data('zoom') : this.options.zoom;
            this.lat = !empty(this.container.data('lat')) ? this.container.data('lat') : this.options.lat;
            this.lng = !empty(this.container.data('lng')) ? this.container.data('lng') : this.options.lng;
            this.style = !empty(this.container.data('style')) ? this.container.data('style') : this.options.style;
            this.edited = isset(this.container.data('edited'));
            this.output = this.container.parent().find('input');
            this.markersList = isset(this.container.data('markers-box')) ? $(this.container.data('markers-box')) : '';
            this.markers = [];
            this.infobox = [];
            this.prev = [];

            this.loadMap();
            this.watch();
        },
        loadMap: function(){
            var self = this;
            this.map = new google.maps.Map(this.container.get(0), {
                zoom: this.zoom,
                center: {lat: this.lat, lng: this.lng},
                styles: this.style
            });

            if(this.markerJson){
                $.each(this.markerJson, function(key, value){
                    if(isset(this['marker-lat']) && isset(this['marker-lng']) && isset(this['marker-title'])){
                        self.addMarker(key, {
                            coordinate: {lat: parseFloat(this['marker-lat']), lng: parseFloat(this['marker-lng'])},
                            title: this['marker-title'],
                            image: this['marker-image'],
                            content: this['marker-desc'],
                            url: this['marker-url']
                        });
                    }
                });
            }
        },
        addMarker: function(key, location){
            var self = this;

            this.markers[key] = [];
            this.markers[key] = new google.maps.Marker({
                position: location.coordinate,
                map: this.map,
                icon: this.icon
            });

            if(!empty(location.title) && (!empty(location.content) || !empty(location.image))){
                location.btn = '';
                location.image = '';

                if(!empty(location.url)){
                    location.btn += '<a href="'+location.url+'" target="_blank" class="btn btn-map">'+messages.btn.more+'</a>';
                }
                if(!empty(location.image)){
                    location.image = '<img src="'+location.image+'" alt="'+location.title+'">';
                }
                if(!empty(location.content)){
                    location.content = '<p>'+location.content+'</p>';
                }else{
                    location.content = '';
                }

                var contentString = '<div class="map-container">'+
                    '<div class="map-content">'+
                    location.image+
                    '<div class="inside">' +
                    '<h1 class="map-title">'+location.title+'</h1>'+
                    location.content+
                    location.btn+
                    '</div>'+
                    '</div>'+
                    '</div>';

                this.infobox[key] = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 200
                });

                this.markers[key].addListener('click', function() {
                    self.openInfo(key);
                });
            }
        },
        watch: function(){
            var self = this;

            if(self.edited){
                if(self.output.val() && isJson(self.output.val())) {
                    self.addMarker('click', {coordinate: JSON.parse(self.output.val())});
                }
                self.map.addListener('click', function(event) {
                    if(isset(self.markers['click'])){
                        self.markers['click'].setMap(null);
                    }

                    self.addMarker('click', {coordinate: event.latLng});
                    self.output.val('{"lat": '+event.latLng.lat()+',"lng": '+event.latLng.lng()+'}').trigger('change');
                });
            }

            if(self.markersList.length){
                self.markersList.find('li').click(function(){
                    var key = $(this).data('key');
                    var element = $(this);

                    if(isset(self.prev[0])) {
                        self.infobox[self.prev[0]].close(self.map, self.markers[key]);
                    }
                    if(isset(self.infobox[key])){
                        self.openInfo(key, true);

                        google.maps.event.addListener(self.infobox[key],'closeclick',function(){
                            element.removeClass('active');
                        });
                    }
                    self.markersList.find('li').removeClass('active');
                    element.addClass('active');
                });
            }
        },
        openInfo: function(key, center){
            var self = this;

            if(isset(self.prev[0])) {
                self.infobox[self.prev[0]].close(self.map, self.markers[key]);
            }
            if(center){
                self.map.setCenter(self.markers[key].position);
            }

            self.prev = [key];
            self.infobox[key].open(self.map, self.markers[key]);

            var iwOuter = $('.gm-style-iw');
            iwOuter.parent().addClass('gm-popup');

            var iwBackground = iwOuter.prev();
            iwOuter.next().hide().addClass('close');
            iwBackground.children(':nth-child(2)').css({'display' : 'none'});
            iwBackground.children(':nth-child(4)').css({'display' : 'none'});
        }
    };

    $.fn.googleMap = function(option){
        var options = $.extend({
            lat: 47.4962259,
            lng: 19.0345682,
            zoom: 12,
            icon: '',
            style: []
        }, option);

        return this.each(function() {
            $.data(this, "googleMap", new googleMap($(this), options));
        });
    };

    $(function(){
        var map = $('.map');

        if(map.length){
            $.getScript("https://maps.googleapis.com/maps/api/js?key="+settings.map, function(){$('.map').googleMap()});
        }
    });
}(jQuery));