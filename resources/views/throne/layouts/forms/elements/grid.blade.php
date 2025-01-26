<li class="box clearfix" data-type="grid">
    <div class="title-box">
        <div class="icon"><i class="fas fa-th-large"></i></div>
        <div class="title">@lang('admin.forms.form.menu.grid')</div>
    </div>
    <ul class="actions">
        <li class="delete btn btn-danger btn-xs"><i class="far fa-trash-alt fa-fw"></i></li>
    </ul>
    <div class="row grids">
        <ul class="col-sm-6 sortable">
            @if(isset($item[0]['grid']) && count($item[0]['grid']))
                @foreach($item[0]['grid'] as $grid)
                    @include('throne.layouts.forms.elements.'.$grid['type'], ['item' => $grid])
                @endforeach
            @endif
        </ul>
        <ul class="col-sm-6 sortable">
            @if(isset($item[1]['grid']) && count($item[1]['grid']))
                @foreach($item[1]['grid'] as $grid)
                    @include('throne.layouts.forms.elements.'.$grid['type'], ['item' => $grid])
                @endforeach
            @endif
        </ul>
    </div>
</li>