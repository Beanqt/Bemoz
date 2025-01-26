<?php namespace App\Models;

use App\Http\Controllers\Slim\Slim;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Popup extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'popup';
    public static $permissions = ['read', 'new', 'edit', 'delete', 'trash'];
    public $validator = [];

    protected $table = 'popup';
    public $lists = [
        'id',
        'title',
    ];

    public function isValid($e, $edit = null){
        $messages = [
            'required' => trans('admin.alert.required')
        ];
        $rules = [
            'title' => 'required',
            'public_at' => 'required',
        ];

        $validator = Validator::make($e,$rules,$messages);

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
            $model->lang = $e['lang'];
        }

        if(isset($data['data']['text'])) {
            $e['data']['text'] = $data['data']['text'];
        }

        $image = new Slim();
        if($e['main_type'] == 1){
            if($image->hasImage()){
                $image->save(self::$name);
                $model->image = $image->getName();
                $model->image_crop = $image->getCrop();
            }
        }else{
            if(!empty($data['image'])){
                $image->remove(self::$name, $data['image']);
            }
            $model->image = '';
            $model->image_crop = '';
        }

        $model->title = $e['title'];
        $model->type = $e['type'];
        $model->second = $e['second'];
        $model->public_at = $e['public_at'];
        $model->finish_at = $e['finish_at'];
        $model->pages = json_encode(isset($e['pages']) ? $e['pages'] : []);
        $model->data = json_encode(isset($e['data']) ? $e['data'] : []);
        $model->save();

        if($image->hasImage() && $data && !empty($data['image'])){
            $image->remove(self::$name, $data['image']);
        }

        return $model;
    }

    public function scopePublic($query) {
        return $query->whereRaw('(active = 1 AND (public_at <= NOW() AND (finish_at >= NOW() OR finish_at = "0000-00-00 00:00:00")))');
    }
    public function scopeLang($query) {
        return $query->where('lang', app('LanguageService')->getLangId());
    }
}
