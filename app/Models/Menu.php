<?php namespace App\Models;

use App\Http\Controllers\Slim\Slim;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Menu extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'menu';
    public static $permissions = ['read', 'new', 'edit', 'delete', 'trash'];
    public $validator = [];

    protected $table = 'menu';
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
            $model->main_type = $e['main_type'];
        }

        if(!$e['main_type'] == 1){
            $image = new Slim();
            if(isset($e['removeImage']) && $e['removeImage']==1){
                if(!empty($old['image'])){
                    $image->remove('menu', $old['image']);
                }
                $model->image = '';
                $model->image_crop = '';
            }
            if($image->hasImage()){
                $image->save('menu');
                $model->image = $image->getName();
                $model->image_crop = $image->getCrop();
            }
        }

        $model->title = $e['title'];
        $model->type = $e['type'];
        $model->url = $this->getUrl($e);
        $model->external = $e['external'];
        $model->public_at = $e['public_at'];
        $model->finish_at = $e['finish_at'];
        $model->data = json_encode(isset($e['data']) ? $e['data'] : []);
        $model->auth = isset($e['auth']) ? $e['auth'] : 0;
        $model->save();

        if(!$e['main_type'] && $image->hasImage() && !empty($old['image'])){
            $image->remove('menu', $old['image']);
        }

        return $model;
    }

    public function getUrl($e){
        $url = $e['url'];
        if($e['type'] == 2) {
            $url = $e['page_url'];
        }
        if($e['type'] == 3) {
            $url = $e['feed_category_url'];
        }
        if($e['type'] == 4) {
            $url = $e['feed_item_url'];
        }
        if($e['type'] == 5) {
            $url = $e['feed_label_url'];
        }

        return $url;
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
