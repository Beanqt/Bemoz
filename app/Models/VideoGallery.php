<?php namespace App\Models;

use App\Http\Controllers\Slim\Slim;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class VideoGallery extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'videogallery';
    public static $permissions = ['read', 'new', 'edit', 'delete'];
    public $validator = [];

    protected $table = 'video_category';

    public function isValid($e, $edit = false){
        $messages = [
            'required' => trans('admin.alert.required')
        ];
        $rules = [
            'title' => 'required',
            'slug' => 'required'
        ];

        $validator = Validator::make($e,$rules,$messages);

        $validator->after(function ($validator) use($edit, $e) {
            $result = self::where('slug', $e['slug'])->where('boss', $e['boss'])->count();

            if(($edit && $result && $edit['slug'] != $e['slug']) || (!$edit && $result)){
                $validator->errors()->add('slug', trans('admin.'.self::$name.'.alerts.have'));
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
            $model['active'] = 0;
        }
        $image = new Slim();
        if(isset($e['removeImage']) && $e['removeImage']==1 && $data){
            if(!empty($data['image'])){
                $image->remove('video', $data['image']);
            }
            $model->image = '';
            $model->image_crop = '';
        }
        if($image->hasImage()){
            $image->save('video');
            $model->image = $image->getName();
            $model->image_crop = $image->getCrop();
        }
        $model->title = $e['title'];
        $model->slug = $e['slug'];
        $model->boss = $e['boss'];
        $model->save();

        if($image->hasImage() && $data && !empty($data['image'])){
            $image->remove('video', $data['image']);
        }

        return $model;
    }

    public function videoitem(){
        return $this->hasMany(Video::class,'category','id')->where('active',1)->orderBy('order','asc');
    }
}
