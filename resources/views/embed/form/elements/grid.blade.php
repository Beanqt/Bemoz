<div class="row">
    @if(isset($item['grids'][0]['grid']))
        <div class="col-sm-6">
            @foreach($item['grids'][0]['grid'] as $grid)
                @include('embed.form.elements.'.$grid['type'], ['item' => $grid])
            @endforeach
        </div>
    @endif
    @if(isset($item['grids'][1]['grid']))
        <div class="col-sm-6">
            @foreach($item['grids'][1]['grid'] as $grid)
                @include('embed.form.elements.'.$grid['type'], ['item' => $grid])
            @endforeach
        </div>
    @endif
</div>