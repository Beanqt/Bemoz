$(document).ready(function(){
    var calendarBox = $('#calendar');
    if(calendarBox.length > 0) {
        var category = calendarBox.data('category');
        var code = lang==default_lang ? '' : lang;
        var options = {
            events_source: code+'/api/events/'+category,
            view: 'month',
            tmpl_path: '/tmpls/',
            language: 'hu-HU',
            tmpl_cache: false,
            time_start: '08:00',
            time_split: 60,
            onAfterEventsLoad: function (events) {
                if (!events) {
                    return;
                }
                var list = $('#eventlist');
                list.html('');

                $.each(events, function (key, val) {
                    $(document.createElement('li'))
                        .html('<a href="' + val.url + '">' + val.title + '</a>')
                        .appendTo(list);
                });
            },
            onAfterViewLoad: function (view) {
                $('.calendar .currentDate').text(this.getTitle().replace('.', '').replace(',', '').replace(' ', '. '));
                $('.btn-group button').removeClass('active');
                $('button[data-calendar-view="' + view + '"]').addClass('active');
            },
            classes: {
                months: {
                    general: 'label'
                }
            }
        };

        var calendar = calendarBox.calendar(options);

        $('.btn-group button[data-calendar-nav]').each(function() {
            var $this = $(this);
            $this.click(function() {
                calendar.navigate($this.data('calendar-nav'));
            });
        });

        $('.btn-group button[data-calendar-view]').each(function() {
            var $this = $(this);
            $this.click(function() {
                calendar.view($this.data('calendar-view'));
            });
        });

        $('#first_day').change(function(){
            var value = $(this).val();
            value = value.length ? parseInt(value) : null;
            calendar.setOptions({first_day: value});
            calendar.view();
        });

        $('#language').change(function(){
            calendar.setLanguage($(this).val());
            calendar.view();
        });

        $('#events-in-modal').change(function(){
            var val = $(this).is(':checked') ? $(this).val() : null;
            calendar.setOptions({modal: val});
        });
        $('#format-12-hours').change(function(){
            var val = $(this).is(':checked') ? true : false;
            calendar.setOptions({format12: val});
            calendar.view();
        });
        $('#show_wbn').change(function(){
            var val = $(this).is(':checked') ? true : false;
            calendar.setOptions({display_week_numbers: val});
            calendar.view();
        });
        $('#show_wb').change(function(){
            var val = $(this).is(':checked') ? true : false;
            calendar.setOptions({weekbox: val});
            calendar.view();
        });
        $('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
            e.preventDefault();
            e.stopPropagation();
        });
    }
});
