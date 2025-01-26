<?php namespace App\Models;

use App\Http\Controllers\Slim\Slim;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class Slider extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'slider';
    public static $permissions = ['read', 'new', 'edit', 'delete', 'trash'];
    public $validator = [];

    protected $table = 'slider';
    public $lists = [
        'id',
        'title',
    ];

    public function isValid($e, $edit = null){
        $messages = [
            'required' => trans('admin.alert.required'),
            'mimes' => trans('admin.alert.mimes')
        ];
        $rules = [
            'title' => 'required',
            'type' => 'required',
            'public_at' => 'required',
        ];

        if(isset($e['type']) && $e['type']){
            foreach(['mp4', 'webm'] as $item){
                $rules[$item] = 'max:512000|mimes:'.$item;
            }
        }

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
        if($image->hasImage()){
            $image->save(self::$name);
            $model->image = $image->getName();
            $model->image_crop = $image->getCrop();
        }

        $model->title = $e['title'];
        $model->public_at = $e['public_at'];
        $model->finish_at = $e['finish_at'];
        $model->data = json_encode(isset($e['data']) ? $e['data'] : []);
        $model->type = $e['type'];
        $model->auth = isset($e['auth']) ? $e['auth'] : 0;

        if($e['type']){
            foreach(['mp4', 'webm'] as $item){
                $file = request()->file($item);
                if($file){
                    $filename = slug($e['title']).'-'.time(). '.' . $file->getClientOriginalExtension();
                    $path = public_path('/uploads/'.self::$name.'/'.$filename);

                    $file->move(public_path('/uploads/'.self::$name.'/'), $path);

                    $model->{$item} = $filename;
                }
            }
        }

        $model->save();

        if($data) {
            if($image->hasImage() && !empty($data['image'])) {
                $image->remove(self::$name, $data['image']);
            }

            if($e['type']) {
                foreach(['mp4', 'webm'] as $item) {
                    $file = request()->file($item);
                    if($file && isset($data[$item]) && !empty($data[$item])) {
                        if(file_exists(public_path('uploads/'.self::$name.'/' . $data[$item]))) {
                            unlink(public_path('uploads/'.self::$name.'/' . $data[$item]));
                        }
                    }
                }
            }
        }

        return $model;
    }

    public function scopeAuth($query) {
        return $query->whereIn('auth', session('visitor_type'));
    }
    public function scopePublic($query) {
        return $query->whereRaw('(active = 1 AND (public_at <= NOW() AND (finish_at >= NOW() OR finish_at = "0000-00-00 00:00:00")))');
    }
    public function scopeLang($query) {
        return $query->where('lang', app('LanguageService')->getLangId());
    }
}
