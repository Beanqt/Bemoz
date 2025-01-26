@if(!empty($item['image']) && file_exists(public_path($src.$item['image'])))
    <img class="img-responsive img-center{{$class ?? ''}}" src="{{$src}}{{$item['image']}}" alt="{{$item['title']}}">
@else
    <img class="img-responsive img-center{{$class ?? ''}}" src="/images/{{isset($no_image) ? $no_image : 'no-image.jpg'}}" alt="{{$item['title']}}">
@endif