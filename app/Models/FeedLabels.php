<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class FeedLabels extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'feed_labels';
    public static $permissions = ['read', 'new', 'edit', 'delete', 'trash'];
    public $validator = [];

    protected $table = 'feed_labels';
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
        $model->save();

        return $model;
    }

    public function scopeLang($query) {
        return $query->where('lang', app('LanguageService')->getLangId());
    }

    public function feeds(){
        return $this->belongsToMany(FeedItem::class, 'feed_item_labels', 'label', 'item');
    }
}
