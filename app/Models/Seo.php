<?php namespace App\Models;

use App\Http\Controllers\Slim\Slim;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model {

    protected $table = 'seo';

    public static function saveData($e, $type, $element){
        $model = self::where('type', $type)->where('element', $element)->first();
        $image = new Slim('seo_image');

        if(!$model){
            $model = new self();
            $model->type = $type;
            $model->element = $element;
        }else{
            $old = clone $model;

            if(isset($e['removeImage_seo']) && $e['removeImage_seo']==1){
                if(!empty($old['image'])){
                    $image->remove('seo', $old['image']);
                }

                $model->image = '';
                $model->image_crop = '';
            }
        }

        if($image->hasImage()){
            $image->save('seo');
            $model->image = $image->getName();
            $model->image_crop = $image->getCrop();
        }

        $model->timestamps = false;
        $model->title = $e['seo_title'];
        $model->keywords = $e['seo_keywords'];
        $model->desc = $e['seo_desc'];
        $model->addthis = isset($e['addthis']) ? 1 : 0;
        $model->nofollow = isset($e['nofollow']) ? 1 : 0;
        $model->save();

        if(isset($old) && $image->hasImage() && !empty($old['image'])){
            $image->remove('seo', $old['image']);
        }

        return $model;
    }
}
