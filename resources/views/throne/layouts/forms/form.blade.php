<?php $newsletter = false; ?>
@if(isset($data['json']) && is_array($data['json']))
    @foreach($data['json'] as $item)
        @if(isset($item['grids']))
            @foreach($item['grids'][0]['grid'] as $grid)
                @if($grid['type'] == 'newsletter')
                    <?php $newsletter = true; ?>
                @endif
            @endforeach
            @foreach($item['grids'][1]['grid'] as $grid)
                @if($grid['type'] == 'newsletter')
                    <?php $newsletter = true; ?>
                @endif
            @endforeach
        @elseif($item['type'] == 'newsletter')
            <?php $newsletter = true; ?>
        @endif
    @endforeach
@endif

<form method="post" autocomplete="off">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" class="json" name="json">
    <input type="hidden" id="submit" name="submit" value="1">
    <div class="box">
        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
            <label for="title">@lang('admin.forms.form.title')<span class="required">*</span></label>
            <input type="text" class="form-control" data-focus="true" name="title" id="title" value="{{$data['title'] ?? ''}}" required>
            <div class="help-block with-errors">
                {!! $errors->first('title', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group sendy {{$errors->has('option.sendy') ? 'has-error' : ''}}" style="display: {{$newsletter ? 'block' : 'none'}}">
            <label for="sendy">@lang('admin.forms.form.sendy')<span class="required">*</span></label>
            <input type="text" class="form-control" name="option[sendy]" id="sendy" value="{{$data['data']['option']['sendy'] ?? ''}}">
            <div class="help-block with-errors">
                {!! $errors->first('option.sendy', '<ul class="list-unstyled"><li>:message</li></ul>') !!}
            </div>
        </div>
        <div class="form-group">
            <label for="option[button][text]">@lang('admin.forms.form.elements.button.text')<span class="required">*</span></label>
            <input type="text" class="form-control" name="option[button][text]" id="option[button][text]" value="{{$data['data']['option']['button']['text'] ?? ''}}" required>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="option[button][align]">@lang('admin.forms.form.elements.button.align')</label>
            <select class="form-control form-custom-select input-align" name="option[button][align]" id="option[button][align]" {{isset($data['live']) && $data['live'] ? 'disabled' : ''}}>
                <option value="left" {{!isset($data['data']['option']['button']['align']) || (isset($data['data']['option']['button']['align']) && $data['data']['option']['button']['align'] == 'left') ? 'selected' : ''}}>@lang('admin.forms.form.elements.button.left')</option>
                <option value="center" {{isset($data['data']['option']['button']['align']) && $data['data']['option']['button']['align'] == 'center' ? 'selected' : ''}}>@lang('admin.forms.form.elements.button.center')</option>
                <option value="right" {{isset($data['data']['option']['button']['align']) && $data['data']['option']['button']['align'] == 'right' ? 'selected' : ''}}>@lang('admin.forms.form.elements.button.right')</option>
            </select>
            <div class="help-block with-errors"></div>
        </div>
    </div>
    @if(isset($data['live']) && $data['live'])
        <div class="alert alert-danger">@lang('admin.forms.alerts.live')</div>
    @endif
    <div class="row">
        <div class="col-sm-3 sticky {{isset($data['live']) && $data['live'] ? 'hidden' : ''}}">
            <ul class="formMenu">
                @include('throne.layouts.forms.elements.text', ['item' => []])
                @include('throne.layouts.forms.elements.textarea', ['item' => []])
                @include('throne.layouts.forms.elements.email', ['item' => []])
                @include('throne.layouts.forms.elements.date', ['item' => []])
                @include('throne.layouts.forms.elements.number', ['item' => []])
                @include('throne.layouts.forms.elements.checkbox', ['item' => []])
                @include('throne.layouts.forms.elements.radio', ['item' => []])
                @include('throne.layouts.forms.elements.select', ['item' => []])
                @include('throne.layouts.forms.elements.range', ['item' => []])
                @include('throne.layouts.forms.elements.html', ['item' => []])
                @include('throne.layouts.forms.elements.aszf', ['item' => []])
                @include('throne.layouts.forms.elements.file', ['item' => []])
                @if(setting('map'))
                    @include('throne.layouts.forms.elements.map', ['item' => []])
                @endif
                @include('throne.layouts.forms.elements.newsletter', ['item' => []])
                @include('throne.layouts.forms.elements.grid', ['item' => []])
            </ul>
        </div>
        <div class="col-sm-{{isset($data['live']) && $data['live'] ? 12 : 9}}">
            <div id="droppable" class="connectedSortable">
                <ul class="sortable">
                    @if(isset($data['json']) && is_array($data['json']))
                        @foreach($data['json'] as $item)
                            @if(isset($item['grids']))
                                @include('throne.layouts.forms.elements.grid', ['item' => $item['grids']])
                            @else
                                @include('throne.layouts.forms.elements.'.$item['type'])
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <br>
    @include('throne.widgets.actions', [
        'save' => true,
        'saveClose' => true,
        'cancel' => route('throne.forms'),
    ])
</form>
<ul class="templates hidden">
    @include('throne.layouts.forms.elements.option', ['item' => []])
</ul>
<style>
    #droppable {
        min-height: 570px;
        border: 1px dashed rgba(0, 0, 0, 0.11);
        padding: 4px;
    }
    #droppable > .sortable {
        min-height: 570px;
    }
    .sortable {
        min-height: 20px;
        padding: 0;
        margin: 0;
        list-style: none;
        position: relative;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .sortable > li {
        margin-bottom: 10px;
        padding: 5px 10px;
        position: relative;
        cursor: move;
        width: 100% !important;
    }
    .sortable > li:not(.ui-state-highlight) {
        height: auto !important;
        z-index: 1 !important;
    }
    .sortable > li.ui-sortable-helper {
        z-index: 2 !important;
    }
    .sortable > li:hover > .actions {
        display: block;
    }
    .sortable li .actions {
        position: absolute;
        padding: 0;
        margin: 0;
        list-style: none;
        top: 4px;
        right: 11px;
        display: none;
    }
    .sortable li .actions .btn {
        padding: 2px;
    }
    .sortable li .icon {
        position: absolute;
        border-right: 1px solid #e2e2e2;
        padding-right: 7px;
        width: 20px;
        text-align: center;
    }
    .sortable li .title {
        padding-left: 30px;
    }
    .sortable li .more {
        display: none;
    }
    .sortable li .more > .form-group:first-child, .sortable li .more hr {
        border-top: 1px solid #e2e2e2;
        margin-top: 5px;
        padding-top: 10px;
    }
    .sortable li .more hr {
        margin-bottom: 0;
    }
    .sortable li .more > .form-group:last-child {
        margin-bottom: 10px;
    }
    .sortable li .more .options {
        background: #f7f7f7;
        padding: 10px;
        margin: 0;
        list-style: none;
    }
    .sortable li .more .option-header {
        border-bottom: 1px solid #e2e2e2;
        padding-bottom: 4px;
        font-weight: bold;
        position: sticky;
        top: 56px;
        background: #fff;
        z-index: 1;
    }
    .sortable li .more .options li {
        position: relative;
        cursor: move;
    }
    .sortable li .more .options li:hover {
        background: #dbdbdb;
    }
    .sortable li .more .options li:last-child {
        margin-bottom: 0;
    }
    .sortable li .more .options .form-group {
        margin-bottom: 0;
    }
    .sortable li .more .options .delete {
        position: absolute;
        right: 0;
        top: 0;
        padding: 2px;
    }
    .formMenu {
        margin: 0;
        padding: 0;
        list-style: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .formMenu li {
        background: #364150;
        white-space: nowrap;
        box-shadow: 0 1px 1px rgba(0,0,0,0.2);
        margin-bottom: 8px;
        color: #fff;
        border-radius: 4px;
        overflow: hidden;
        padding: 6px 5px 6px 38px;
        position: relative;
        cursor: pointer;
        width: 100%;
        z-index: 2;
    }
    .formMenu li.ui-draggable-dragging {
        z-index: 3 !important;
    }
    .formMenu li.disabled {
        opacity: 0.2;
        cursor: not-allowed;
    }
    .formMenu li .icon {
        background: #1e252f;
        padding: 8px;
        font-size: 14px;
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 30px;
        text-align: center;
    }
    .formMenu .grids,
    .formMenu .actions,
    .formMenu .more {
        display: none;
    }
    .grids {
        margin: 0 -10px;
    }
    .grids .sortable {
        min-height: 40px;
        position: relative;
        padding: 10px 15px;
    }
    .grids .sortable .col-md-6 {
        width: 100%;
    }
    .grids .sortable:before {
        content: '';
        display: block;
        position: absolute;
        top: 5px;
        left: 10px;
        right: 10px;
        bottom: 5px;
        border: 1px dotted #e2e2e2;
        background: #f7f7f7;
    }
    .ui-state-highlight {
        border: 0;
        background: rgba(0,0,0,0.08);
        min-height: 30px;
    }
</style>
<script>
    var editor_id = 1;
    var editors = [];
    var ckeditor_default = {
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
    };

    app.page.mounted = function(manager){
        var droppable = $('#droppable');
        var menu = $('.formMenu');

        @if(!isset($data['live']) || (isset($data['live']) && !$data['live']))
            droppable.find('.ck_textarea').each(function(){
                $(this).attr('id', 'ckeditor'+editor_id);
                replaceCkeditor('ckeditor'+editor_id);
                editor_id++;
            });
            droppable.find(".options").sortable().disableSelection();

            app.page.beforeSend(function(){
                getFromJson();
            });

            menu.find('li').draggable({ helper: "clone", connectToSortable: ".sortable" });

            initSortable();

            manager.content.find('form').on('click','.delete', function(){
                var parent = $(this).parents('li').first();

                if(parent.data('type') == 'button'){
                    menu.find('[data-type=button]').removeClass('disabled');
                }
                if(parent.data('type') == 'newsletter'){
                    menu.find('[data-type=newsletter]').removeClass('disabled');
                    $('.sendy').hide().find('input').val('');
                }

                parent.remove();
            });
        @endif

        manager.content.find('form').on('click','.actions .edit', function(){
            $(this).parents('li').first().find('.more').stop(true).slideToggle(200);
        });
        manager.content.find('form').on('keyup','.input-title', function(){
            var value = $(this).val();
            var title = $(this).parents('li').first().find('.title');
            if(value.length > 0) {
                title.text(value);
            }else{
                title.text(title.attr('data-orig-title'));
            }
        });
        manager.content.find('form').on('click','.add-option', function(){
            var parent = $(this).parents('.options-box').first();

            parent.find('.options').append($('.templates').find('>.option-template').clone());
        });
    };

    function initSortable(){
        $(".sortable").sortable({
            connectWith: ".sortable",
            placeholder: "ui-state-highlight",
            forcePlaceholderSize: true,
            receive: function( event, ui ) {
                var item = $(ui.item);
                var helper = $(ui.helper);

                if(item.hasClass('disabled')){
                    ui.helper.remove();
                    return true;
                }

                if(['html','aszf','newsletter'].indexOf(item.data('type')) >= 0){
                    if(item.data('type') == 'newsletter'){
                        item.addClass('disabled');
                        $('.sendy').show();
                    }

                    helper.find('.ck_textarea').attr('id', 'ckeditor'+editor_id);
                    editor_id++;
                }else if(item.data('type') == 'grid'){
                    initSortable();
                }else{
                    if(item.data('type') == 'button'){
                        item.addClass('disabled');
                    }
                    if(['checkbox','radio','select'].indexOf(item.data('type')) >= 0){
                        helper.find(".options").sortable().disableSelection();
                    }
                }
            },
            start: function(event, ui){
                ui.placeholder.height(ui.item.height());
                removeCkeditor(ui.item.find('.ck_textarea').attr('id'))
            },
            stop: function(event, ui){
                replaceCkeditor(ui.item.find('.ck_textarea').attr('id'))
            }
        }).disableSelection();
    }

    function removeCkeditor(textareaId){
        if (typeof textareaId != 'undefined') {
            var editorInstance = CKEDITOR.instances[textareaId];
            editorInstance.destroy();
            CKEDITOR.remove( textareaId );
        }
    }
    function replaceCkeditor(textareaId){
        if (typeof textareaId != 'undefined') {
            CKEDITOR.replace( textareaId, ckeditor_default);
        }
    }
    function getFromJson(){
        var output = $('.json');
        var array = [];

        $('#droppable > .sortable').find('>li').each(function(){
            var li = $(this);
            if(li.data('type') == 'grid'){
                var grids_array = {'grids': []};
                li.find('.sortable').each(function(){
                    var grid_array = {'grid': []};

                    $(this).find('>li').each(function(){
                        grid_array.grid.push(getInputJson($(this)));
                    });
                    grids_array.grids.push(grid_array);
                });
                array.push(grids_array);
            }else {
                array.push(getInputJson(li));
            }
        });

        output.val(JSON.stringify(array));
    }

    function getInputJson(li){
        var sub_array = { };
        var type = li.data('type');
        var name = type+'-'+(new Date().valueOf())+'-'+(new Date().getMilliseconds());
        sub_array.type = type;

        sub_array.name = name;
        if(li.find('.input-title').length){
            sub_array.name = convertToSlug(li.find('.input-title').val());
        }else if(li.find('.input-label').length){
            sub_array.name = convertToSlug(li.find('.input-label').val());
        }else if(li.find('.input-placeholder').length){
            sub_array.name = convertToSlug(li.find('.input-placeholder').val());
        }

        li.find('input, select, textarea').not('[type=checkbox]').not('[type=radio]').each(function(){
            if(!$(this).parents('.options').length){
                if($(this).hasClass('ck_textarea')){
                    var id = $(this).attr('id');
                    var editorInstance = CKEDITOR.instances[id];
                    sub_array[$(this).data('name')] = editorInstance.getData();
                }else{
                    sub_array[$(this).data('name')] = $(this).val();
                }
            }
        });

        li.find('input[type=checkbox], input[type=radio]').each(function(){
            var options = li.find('.options');
            sub_array[$(this).data('name')] = $(this).is(':checked');

            if(options.length){
                sub_array.options = [];
                options.find('li').each(function(){
                    var option = {};
                    option.title = $(this).find('.option-title').val();
                    option.value = $(this).find('.option-value').val();

                    sub_array.options.push(option);
                });
            }
        });

        return sub_array;
    }

    function convertToSlug(text)
    {
        text = text.toLowerCase();

        var from = "áéíőóöúü_,:;";
        var to   = "aeiooouu----";
        for (var i=0, l=from.length ; i<l ; i++) {
            text = text.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }
        return text.replace(/[^\w ]+/g,'').replace(/ +/g,'-');
    }
</script>