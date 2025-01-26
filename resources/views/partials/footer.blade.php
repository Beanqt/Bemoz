<footer>
    <div class="partners">
        <div class="container">
            <div class="col-md-10 col-md-offset-1 slick-partners">
                @foreach(app('HelperService')->getPartners() as $item)
                    <div class="item">
                        <a href="{{$item['url']}}" title="{{$item['title']}}" target="_blank">
                            <img src="/uploads/partner_items/small-{{$item['image']}}" alt="{{$item['title']}}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="container">
        {!! app("MenuService")->footer() !!}
    </div>
    <div class="copyright text-right">
        <div class="container">
            @lang('public.footer.copyright') 2021 {{date('Y') != 2021 ? '- '.date('Y') : ''}} XY | <span>@lang('public.footer.powered')</span> <a href="https://positive.hu/" target="_blank">Positive Adamsky</a>
        </div>
    </div>
</footer>
<div class="scroll-up"><i class="fas fa-angle-up"></i></div>

@if($popup = app('PopupService')->get())
    <script>
        $(function(){
            var popup = $('.modal-popup');
            popup.modal('show');
        });
    </script>
    <div class="modal fade modal-popup {{empty($popup['image']) ? 'small' : ''}}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body popup-container">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    @if(!empty($popup['image']))
                        <img class="img-responsive" src="/uploads/popup/small-{{$popup['image']}}" alt="{{$popup['title']}}">
                    @endif

                    <div class="popup-content text" style="background: {{$popup['data']['text']['bgcolor'] ?? 'rgba(0,0,0,0)'}}; text-align: {{$popup['data']['text']['position'] ?? 'left'}}; color: {{$popup['data']['text']['color'] ?? '#fff'}}" data-top="{{$popup['data']['text']['y'] ?? 0}}" data-left="{{$popup['data']['text']['x'] ?? 0}}">
                        <div class="title">{{$popup['data']['title']}}</div>
                        <div class="content">{{$popup['data']['content']}}</div>
                        @if(isset($popup['data']['button'],$popup['data']['url']) && !empty($popup['data']['button']) && !empty($popup['data']['url']))
                            <a style="border-color: {{$popup['data']['text']['color'] ?? '#fff'}};color: {{$popup['data']['text']['color'] ?? '#fff'}}" class="btn" href="{{$popup['data']['url']}}" {!! isset($popup['data']['target']) && $popup['data']['target'] ? 'target="_blank"' : '' !!}>{{$popup['data']['button']}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="modal fade ajax-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal fade modal-default modal-delete modal-danger">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('admin.modal_delete.head')</h4>
            </div>
            <div class="modal-body">
                @lang('admin.modal_delete.body')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small" data-dismiss="modal">@lang('admin.btn.no')</button>
                <a href="" class="btn btn-default btn-danger btn-small btn-load">@lang('admin.btn.yes')</a>
            </div>
        </div>
    </div>
</div>