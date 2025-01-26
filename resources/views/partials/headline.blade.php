@section('head')
    <h1>{{$title ?? ''}}</h1>
@stop
<div class="headline">
    @if(isset($grid))
        <div class="row inline-row">
            <div class="col-md-7 col-lg-6 inline-col">
                @section('head')
                @show
            </div>
            <div class="col-md-5 col-lg-6 inline-col text-right">
                @section('headSide')
                @show
            </div>
        </div>
    @else
        @section('head')
        @show
    @endif
    @include('partials.breadcrumb')
</div>