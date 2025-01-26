@section('widgetFaq-'.$id)
    <div class="panel-group" id="category-box-{{$id}}" role="tablist">
        @foreach($widget['data'] as $key => $faq)
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading-{{$key}}">
                    <div class="fakeId" id="{{slug($faq['title'])}}"></div>
                    <div class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#category-box-{{$id}}" href="#collapse-{{$key}}" aria-expanded="true" aria-controls="collapse-{{$key}}">
                            {{$faq['title']}} <span class="fas fa-angle-down"></span>
                        </a>
                    </div>
                </div>
                <div id="collapse-{{$key}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{$key}}">
                    <div class="panel-body">
                        {!! app('HelperService')->getSimpleContent($faq['content']) !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop

<div class="widgetBox widgetBox-{{$id}} widgetFaq">
    @if((isset($widget['style']['template']) && $widget['style']['template'] == 1) || $layout == 1)
        @section('widgetFaq-'.$id)
        @show
    @else
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @section('widgetFaq-'.$id)
                    @show
                </div>
            </div>
        </div>
    @endif
</div>

