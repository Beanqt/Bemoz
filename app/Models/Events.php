<?php namespace App\Models;

use App\Http\Controllers\Slim\Slim;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Events extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'events';
    public static $permissions = ['read', 'new', 'edit', 'delete', 'trash'];
    public $validator = [];

    protected $table = 'events';
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
            'slug' => 'required',
            'event_start' => 'required',
            'event_end' => 'required',
            'public_at' => 'required',
        ];

        $validator = Validator::make($e,$rules,$messages);

        $validator->after(function ($validator) use($edit, $e) {
            $result = self::where('slug', $e['slug'])->where('lang',$e['lang'])->count();

            $image = new Slim();
            if(!$edit && !$image->hasImage()){
                $validator->errors()->add('image', trans('admin.alert.noimage'));
            }
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
            $model->lang = $e['lang'];
        }

        $image = new Slim();
        if($image->hasImage()){
            $image->save(self::$name);
            $model->image = $image->getName();
            $model->image_crop = $image->getCrop();
        }

        $model->category = $e['category'];
        $model->title = $e['title'];
        $model->slug = $e['slug'];
        $model->place = $e['place'];
        $model->short = $e['short'];
        $model->content = getJsonContent($e);
        $model->event_start = $e['event_start'];
        $model->event_end = $e['event_end'];
        $model->public_at = $e['public_at'];
        $model->finish_at = $e['finish_at'];
        $model->auth = isset($e['auth']) ? $e['auth'] : 0;
        $model->save();

        if($data && $image->hasImage() && !empty($data['image'])){
            $image->remove(self::$name, $data['image']);
        }

        $model->seo = Seo::saveData($e, self::$name, $model->id)->toArray();

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

    public function categories(){
        return $this->belongsTo(EventCategory::class,'category','id')->public();
    }
    public function throneCategories(){
        return $this->belongsTo(EventCategory::class,'category','id');
    }
    public function seo() {
        return $this->belongsTo(Seo::class, 'id', 'element')->where('type', self::$name);
    }
}
