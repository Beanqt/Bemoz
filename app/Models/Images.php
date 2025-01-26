<?php namespace App\Models;

use App\Http\Controllers\Slim\Slim;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Images extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'galleryimages';
    public static $permissions = ['read', 'new', 'edit', 'delete'];
    public $validator = [];

    protected $table = 'gallery_image';

    public function isValid($e, $edit = false){
        $messages = [
            'required' => trans('admin.alert.required')
        ];
        $rules = [
            'title' => 'required'
        ];

        $validator = Validator::make($e,$rules,$messages);

        $validator->after(function ($validator) use($e, $edit) {
            $result = self::where('title', $e['title'])->where('category', $e['boss'])->count();

            if($result && $edit['title'] != $e['title']){
                $validator->errors()->add('title', trans('admin.'.self::$name.'.alerts.have'));
            }
        });

        if(!$validator->fails()){
            return true;
        }

        session()->flash('error', trans('admin.alert.haveError'));
        $this->validator = $validator;
        return false;
    }

    public function saveData($e, $data = null){
        if($data){
            $model = self::find($data['id']);
        }else{
            $model = new self();
            $model->category = $e['boss'];
        }

        $model->title = $e['title'];
        $model->slug = slug($e['title']);
        $model->alt = $e['alt'];

        $image = new Slim();
        if($image->hasImage()){
            $image->save('gallery/'.$e['boss']);
            $model->image = $image->getName();
            $model->image_crop = $image->getCrop(true);
        }
        $model->save();

        if($image->hasImage() && !empty($data['image'])){
            $image->remove('gallery/'.$e['boss'], $data['image']);
        }

        return $model;
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class,'category','id')->where('active',1)->orderBy('order','asc');
    }
}
