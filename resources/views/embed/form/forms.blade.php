@section('content-'.$id)
    <form method="post" data-loader="true" action="{{route('form.post', $id)}}" id="form-{{$id}}" {!! $form['file'] ? 'enctype="multipart/form-data"' : '' !!}>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @foreach($form['json'] as $item)
            @if(isset($item['grids']))
                @include('embed.form.elements.grid')
            @else
                @include('embed.form.elements.'.$item['type'])
            @endif
        @endforeach
        <div class="text-{{$form['data']['option']['button']['align'] ?? 'left' }}">
            <button type="submit" class="btn btn-submit">{!! $form['data']['option']['button']['text'] ?? '' !!}</button>
        </div>
    </form>
@stop

<div class="widgetBox widgetForm">
    @if($layout == 1)
        @section('content-'.$id)
        @show
    @else
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @section('content-'.$id)
                    @show
                </div>
            </div>
        </div>
    @endif
</div>

@if(session('form_'.$id.'_success'))
    <script>
        $(document).ready(function(){
            $('.formModal').modal('show');
        });
    </script>

    <div class="modal fade modal-default formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modalBorder" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="modalDesc">@lang('public.form.success_modal.content')</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-more" data-dismiss="modal" aria-label="Close">@lang('public.form.success_modal.btn')</button>
                </div>
            </div>
        </div>
    </div>
@endif