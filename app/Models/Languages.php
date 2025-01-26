<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Waavi\Translation\Facades\TranslationCache;

class Languages extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'languages';
    public static $permissions = ['read', 'new', 'edit', 'delete', 'text', 'publish', 'trash'];
    public $validator = [];

    protected $table = 'translator_languages';

    public function isValid($e, $edit = false){
        $messages = [
            'required' => trans('admin.alert.required')
        ];
        $rules = [
            'name' => 'required',
            'locale' => 'required'
        ];

        $validator = Validator::make($e,$rules,$messages);

        $validator->after(function ($validator) use($edit, $e) {
            $result = self::where('locale', $e['locale'])->first();

            if(($edit && $result && $edit['locale'] != $e['locale']) || (!$edit && $result)){
                $validator->errors()->add('locale', trans('admin.'.self::$name.'.alerts.have'));
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

        $e['locale'] = strtolower($e['locale']);

        $model->name = $e['name'];
        $model->locale = $e['locale'];
        $model->save();

        if($data){
            if(!empty($data['locale']) && $data['locale'] != $e['locale']) {
                if(!file_exists(base_path('resources/lang/'.$e['locale']))) {
                    @mkdir(base_path('resources/lang/'.$e['locale']), 0777, true);
                }

                if (file_exists(base_path('resources/lang/'.$data['locale']))) {
                    rename(base_path('resources/lang/'.$data['locale']), base_path('resources/lang/'.$e['locale']));
                }
            }
        }else{
            if(!file_exists(base_path('resources/lang/'.$e['locale']))) {
                mkdir(base_path('resources/lang/'.$e['locale']));
                copy(base_path('resources/lang/hu/public.php'), base_path('resources/lang/'.$e['locale'].'/public.php'));
            }
        }

        return $model;
    }
}
