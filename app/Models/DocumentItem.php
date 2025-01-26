<?php namespace App\Models;

use App\Http\Controllers\Slim\Slim;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class DocumentItem extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'documentitem';
    public static $permissions = ['read', 'new', 'edit', 'delete'];
    public $validator = [];

    protected $table = 'document_item';

    public function isValid($e, $edit = false){
        $messages = [
            'required' => trans('admin.alert.required')
        ];
        $rules = [
            'title' => 'required'
        ];

        $validator = Validator::make($e,$rules,$messages);

        $validator->after(function ($validator) use($e, $edit) {
            $result = self::where('title', $e['title'])->where('category', $e['boss'])->count();

            if($result && $edit['title'] != $e['title']){
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
            $model->boss = $e['boss'];
        }

        $model->title = $e['title'];
        $model->slug = slug($e['title']);

        if(request()->file('file')){
            $file = request()->file('file');
            $size = $file->getSize();

            $filename = slug($e['title']) .'-'.time(). '.' . $file->getClientOriginalExtension();

            $path = public_path('/uploads/'.self::$name.'/'.$e['boss'].'/' . $filename);
            $file->move(public_path('/uploads/'.self::$name.'/'.$e['boss'].'/'), $path);

            $model->file = $filename;
            $model->size = number_format($size/1024/1024, 2, '.','');
        }

        $image = new Slim();
        if(isset($e['removeImage']) && $e['removeImage']==1){
            if(!empty($data['image'])){
                $image->remove(self::$name.'/'.$e['boss'].'/image', $data['image']);
            }
            $model->image = '';
            $model->image_crop = '';
        }
        if($image->hasImage()){
            $image->save(self::$name.'/'.$e['boss'].'/image');
            $model->image = $image->getName();
            $model->image_crop = $image->getCrop();
        }
        $model->save();

        if($image->hasImage() && !empty($data['image'])){
            $image->remove(self::$name.'/'.$e['boss'].'/image', $data['image']);
        }

        return $model;
    }

    public function documentcategory()
    {
        return $this->belongsTo(DocumentCategory::class,'category','id')->where('active',1)->orderBy('order','asc');
    }
    public function downloads()
    {
        return $this->hasMany(DocumentDownload::class,'document_id','id');
    }
}
