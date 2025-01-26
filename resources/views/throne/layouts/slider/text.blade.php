@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'back' => route('throne.slider'),
                'selectLanguage' => false,
            ])
            <h1>@lang('admin.slider.text')</h1>
        </div>
        <form method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="submit" name="submit" value="1">
            <input type="hidden" id="position-x" name="data[text][x]" value="{{$data['data']['text']['x'] ?? 0}}">
            <input type="hidden" id="position-y" name="data[text][y]" value="{{$data['data']['text']['y'] ?? 0}}">
            <div class="box">
                <div class="form-group">
                    <label for="color">@lang('admin.slider.form.text.color')</label>
                    <div class="input-group text-color-picker">
                        <span class="input-group-addon"><i></i></span>
                        <input type="text" class="form-control" name="data[text][color]" id="color" value="{{$data['data']['text']['color'] ?? '#fff'}}">
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label for="bgcolor">@lang('admin.slider.form.text.bgColor')</label>
                    <div class="input-group bg-color-picker">
                        <span class="input-group-addon"><i></i></span>
                        <input type="text" class="form-control" name="data[text][bgcolor]" id="bgcolor" value="{{$data['data']['text']['bgcolor'] ?? 'rgba(0, 0, 0, 0)'}}">
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="box">
                <label>@lang('admin.slider.form.text.image')</label>
                <div class="image-box">
                    <div class="loader loader-table active"></div>
                    @if(file_exists(public_path('uploads/slider/small-'.$data['image'])))
                        <img class="img-responsive" src="/uploads/slider/small-{{$data['image']}}">
                    @else
                        <img class="img-responsive" src="/images/default.png">
                    @endif
                    <div class="point" data-top="{{$data['data']['text']['y'] ?? 0}}" data-left="{{$data['data']['text']['x'] ?? 0}}">
                        <div class="title">{{$data['data']['title'] ?? 'Title'}}</div>
                        <div class="desc">{{$data['data']['content'] ?? 'Desc'}}</div>
                    </div>
                </div>
            </div>

            @include('throne.widgets.actions', [
                'save' => true,
                'saveClose' => true,
                'cancel' => route('throne.slider'),
            ])
        </form>
    </div>

    <style>
        .image-box {
            position: relative;
            overflow: hidden;
        }
        .point {
            position: absolute;
            min-width: 250px;
            min-height: 65px;
            border: 2px dashed #000;
            top:0;
            left:0;
        }
        .point .title {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .point .desc {
            font-size: 16px;
            font-weight: bold;
        }
    </style>

    <script>
        $('.text-color-picker').colorpicker().on('changeColor', function(e) {
            $('.point').css('color', e.color.toString('rgba'));
        });
        $('.bg-color-picker').colorpicker().on('changeColor', function(e) {
            $('.point').css('background', e.color.toString('rgba'));
        });

        var pointer = function(){
            this.init();
        };

        pointer.prototype = {
            init: function(){
                this.container = $(".image-box");
                this.pointer = this.container.find('.point');
                this.pointerX = 0;
                this.pointerY = 0;
                this.inputX = $("#position-x");
                this.inputY = $("#position-y");
                this.ratio = 1920/this.container.find('img').width();
                this.color = $('#color');
                this.bgcolor = $('#bgcolor');

                this.watch();
            },
            watch: function(){
                var self = this;

                self.pointer.css('color', self.color.val());
                self.pointer.css('background', self.bgcolor.val());

                self.color.change(function(){
                    if($(this).val().length == 0) {
                        self.pointer.css('color', '#fff');
                    }
                });
                self.bgcolor.change(function(){
                    if($(this).val().length == 0) {
                        self.pointer.css('background', 'transparent');
                    }
                });

                self.container.click(function(event){
                    self.pointerX = event.pageX-self.container.offset().left;
                    self.pointerY = event.pageY-self.container.offset().top;

                    self.markersShow();
                });

                self.loadPointer();
            },
            markersShow: function(){
                var self = this;

                self.inputX.val(self.pointerX*self.ratio);
                self.inputY.val(self.pointerY*self.ratio);
                self.pointer.css({top: self.pointerY, left: self.pointerX});
            },
            loadPointer: function(){
                var self = this;
                var x = self.pointer.data('left');
                var y = self.pointer.data('top');

                self.inputX.val(x);
                self.inputY.val(y);

                self.pointer.css({top: y/self.ratio, left: x/self.ratio});
            }
        };

        $(document).ready(function(){
            new pointer();

            $('.image-box').find('.loader').removeClass('active');
        });
    </script>
@stop