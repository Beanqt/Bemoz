<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Pages extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'pages';
    public static $permissions = ['read', 'new', 'edit', 'delete', 'trash'];
    public $validator = [];

    protected $table = 'pages';
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
            'slug' => 'required'
        ];

        $validator = Validator::make($e,$rules,$messages);

        $validator->after(function ($validator) use($edit, $e) {
            $result = self::where('slug', $e['slug'])->where('lang', $e['lang'])->count();

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

        $model->title = $e['title'];
        $model->slug = $e['slug'];
        $model->content = $e['layout'];
        $model->public_at = $e['public_at'];
        $model->finish_at = $e['finish_at'];
        $model->auth = isset($e['auth']) ? $e['auth'] : 0;
        $model->save();

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

    public function seo() {
        return $this->belongsTo(Seo::class, 'id', 'element')->where('type', self::$name);
    }
}
