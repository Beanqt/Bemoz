@if(session('success'))
    <div class="alert alert-success">{!! session('success') !!}</div>
    <?php session()->forget('success'); ?>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
    <?php session()->forget('error'); ?>
@endif
@if(session('info'))
    <div class="alert alert-info">{{session('info')}}</div>
    <?php session()->forget('info'); ?>
@endif