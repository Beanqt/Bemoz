@extends('throne.partials.master')

@section('content')
    <div class="container">
        <div class="page-header">
            @include('throne.widgets.actions', [
                'back' => route('throne.language_text')
            ])
            <h1>@lang('admin.translates.edit')</h1>
        </div>

        <form method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="submit" name="submit" value="1">

            <div class="box">
                <div class="form-group {{$errors->has('item') ? 'has-error' : ''}}">
                    <label for="item">@lang('admin.translates.form.item')<span class="required">*</span></label>
                    <input type="text" class="form-control" name="item" id="item" value="{{$data['item'] ?? ''}}" required readonly>
                    <div class="help-block with-errors">
                        {!! $errors->first('item', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
                    </div>
                </div>
                @foreach($languages as $locale => $name)
                    <?php $have = false; ?>
                    @foreach($items as $item)
                        @if($item['locale'] == $locale)
                            <div class="form-group">
                                <label for="items[{{$item['id']}}]">{{$name}}</label>
                                <textarea class="form-control" name="items[{{$item['id']}}]" id="items[{{$item['id']}}]" rows="5" cols="80">{{$data['items'][$item['id']] ?? $item['text']}}</textarea>
                                <script>
                                    var editor = CKEDITOR.replace( 'items[{{$item['id']}}]', {
                                        toolbar: [
                                            { name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
                                            { name: 'links', items: ['Link','Unlink']}
                                        ],
                                        height: 80,
                                        removePlugins: 'elementspath',
                                        resize_enabled: false,
                                        autoParagraph: false,
                                        enterMode: CKEDITOR.ENTER_BR,
                                        shiftEnterMode: CKEDITOR.ENTER_BR,
                                        entities: false,
                                        entities_latin: false
                                    });
                                </script>
                                <div class="help-block with-errors"></div>
                            </div>
                            <?php $have = true; ?>
                            @break
                        @endif
                    @endforeach

                    @if(!$have)
                        <div class="form-group">
                            <label for="new[{{$locale}}]">{{$name}}</label>
                            <textarea class="form-control" name="new[{{$locale}}]" id="new[{{$locale}}]" rows="5" cols="80">{{$data['new'][$locale] ?? ''}}</textarea>
                            <script>
                                var editor = CKEDITOR.replace( 'new[{{$locale}}]', {
                                    toolbar: [
                                        { name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
                                        { name: 'links', items: ['Link','Unlink']}
                                    ],
                                    height: 80,
                                    removePlugins: 'elementspath',
                                    resize_enabled: false,
                                    autoParagraph: false,
                                    enterMode: CKEDITOR.ENTER_BR,
                                    shiftEnterMode: CKEDITOR.ENTER_BR
                                });
                            </script>
                            <div class="help-block with-errors"></div>
                        </div>
                    @endif
                @endforeach
            </div>

            @include('throne.widgets.actions', [
                'save' => true,
                'saveClose' => true,
                'cancel' => route('throne.language_text'),
            ])
        </form>
    </div>
@stop