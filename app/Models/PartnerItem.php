<?php namespace App\Models;

use App\Http\Controllers\Slim\Slim;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class PartnerItem extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'partner_items';
    public static $permissions = ['read', 'new', 'edit', 'delete', 'trash'];
    public $validator = [];

    protected $table = 'partner_items';
    public $lists = [
        'id',
        'title',
    ];

    public function isValid($e, $edit = false){
        $messages = [
            'required' => trans('admin.alert.required')
        ];
        $rules = [
            'title' => 'required',
        ];

        $validator = Validator::make($e,$rules,$messages);

        $validator->after(function ($validator) use($edit, $e) {
            $result = self::where('title', $e['title'])->count();

            $image = new Slim();
            if(!$edit && !$image->hasImage()){
                $validator->errors()->add('image', trans('admin.alert.noimage'));
            }
            if(($edit && $result && $edit['title'] != $e['title']) || (!$edit && $result)){
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
        }

        $image = new Slim();
        if($image->hasImage()){
            $image->save(self::$name);
            $model->image = $image->getName();
            $model->image_crop = $image->getCrop();
        }

        $model->category = $e['category'];
        $model->title = $e['title'];
        $model->url = checkHttp($e['url']);
        $model->target = $e['target'];
        $model->public_at = $e['public_at'];
        $model->finish_at = $e['finish_at'];
        $model->save();

        if($data && $image->hasImage() && !empty($data['image'])){
            $image->remove(self::$name, $data['image']);
        }

        return $model;
    }

    public function throneCategories(){
        return $this->belongsTo(PartnerCategory::class,'category','id');
    }
}
