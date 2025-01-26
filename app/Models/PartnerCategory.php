<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class PartnerCategory extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'partner_categories';
    public static $permissions = ['read', 'new', 'edit', 'delete', 'trash'];
    public $validator = [];

    protected $table = 'partner_categories';
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
            $result = self::where('title', $e['title'])->where('lang', $e['lang'])->count();

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
            $model->lang = $e['lang'];
        }
        $model->title = $e['title'];
        $model->save();

        return $model;
    }

    public function partnerItems() {
        return $this->hasMany(PartnerItem::class,'category','id')->orderBy('order', 'asc');
    }

    public function scopePublic($query){
        return $query->where('active', 1);
    }
}
