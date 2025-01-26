@if($type == 'forms')
    <?php $module = \App\Models\Forms::find($item['id']); ?>
@elseif($type == 'widget')
    <?php $module = \App\Models\Widget::find($item['id']); ?>
@elseif($type == 'gallery')
    <?php $module = \App\Models\Gallery::find($item['id']); ?>
@elseif($type == 'document_category')
    <?php $module = \App\Models\DocumentCategory::find($item['id']); ?>
@elseif($type == 'video_category')
    <?php $module = \App\Models\VideoGallery::find($item['id']); ?>
@elseif($type == 'video')
    <?php $module = \App\Models\Video::find($item['id']); ?>
@elseif($type == 'images')
    <?php $module = \App\Models\Images::find($item['id']); ?>
@elseif($type == 'document')
    <?php $module = \App\Models\DocumentItem::find($item['id']); ?>
@else
    <?php $module = []; ?>
@endif

@if(!is_null($module))
    @include('throne.widgets.creator.'.$type, ['item' => $item])
@endif