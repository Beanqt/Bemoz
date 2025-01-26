<?php namespace App\Models;

use App\Http\Controllers\Slim\Slim;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class Video extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'videoitem';
    public static $permissions = ['read', 'new', 'edit', 'delete'];
    public $validator = [];

    protected $table = 'video_item';

    public function isValid($e, $edit = false){
        $messages = [
            'required' => trans('admin.alert.required')
        ];
        $rules = [
            'title' => 'required',
            'type' => 'required',
            'gif' => 'mimes:gif',
            'sound' => 'mimes:mpga',
            'mp4' => 'mimes:mp4',
            'webm' => 'mimes:webm',
        ];

        $validator = Validator::make($e,$rules,$messages);

        $validator->after(function ($validator) use($edit, $e) {
            $result = self::where('title',$e['title'])->where('category',$e['boss'])->count();

            if(($edit && $result && $edit['title'] != $e['title']) || (!$edit && $result)){
                $validator->errors()->add('title', trans('admin.'.self::$name.'.alerts.have'));
            }
            foreach(['mp4', 'webm'] as $item){
                $file = request()->file($item);
                if($file){
                    $max_size = setting('upload_video') ? setting('upload_video')*1024*1024 : 104857600;

                    if($file->getSize() > $max_size){
                        $validator->errors()->add($item, trans('admin.alert.size'));
                    }
                }
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

        if (!file_exists(public_path('/uploads/video/'.$e['boss']))) {
            mkdir(public_path('/uploads/video/'.$e['boss']));
        }

        if($e['type'] == 1){
            $model->video_id = $e['youtube_id'];
        }elseif($e['type'] == 2){
            $model->video_id = $e['vimeo_id'];
        }elseif($e['type'] == 3){
            foreach(['mp4', 'webm'] as $item){
                $file = request()->file($item);

                if($file){
                    $filename = slug($e['title']) .'-'.time(). '.' . $file->getClientOriginalExtension();
                    $path = public_path('/uploads/video/'.$e['boss'].'/'.$filename);

                    $file->move(public_path('/uploads/video/'.$e['boss'].'/'), $path);

                    $model->{$item} = $filename;
                }
            }
        }elseif($e['type'] == 4){
            $file = request()->file('gif');

            if($file){
                $filename = slug($e['title']) .'-'.time(). '.' . $file->getClientOriginalExtension();
                $path = public_path('/uploads/video/'.$e['boss'].'/'.$filename);

                $file->move(public_path('/uploads/video/'.$e['boss'].'/'), $path);

                $model->video_id = $filename;
            }
        }elseif($e['type'] == 5){
            $file = request()->file('sound');

            if($file){
                $filename = slug($e['title']) .'-'.time(). '.' . $file->getClientOriginalExtension();
                $path = public_path('/uploads/video/'.$e['boss'].'/'.$filename);

                $file->move(public_path('/uploads/video/'.$e['boss'].'/'), $path);

                $model->video_id = $filename;
            }
        }

        $image = new Slim();
        if(isset($e['removeImage']) && $e['removeImage']==1 && $data){
            if(!empty($data['image'])){
                $image->remove('video/'.$e['boss'], $data['image']);
            }
            $model->image = '';
            $model->image_crop = '';
        }
        if($image->hasImage()){
            $image->save('video/'.$e['boss']);
            $model->image = $image->getName();
            $model->image_crop = $image->getCrop();
        }elseif($e['type'] == 1 && (is_null($data) || ($data && empty($data['image'])))){
            $youtube = 'https://img.youtube.com/vi/'.$e['youtube_id'].'/maxresdefault.jpg';
            $header = get_headers($youtube);
            if(isset($header[0]) && $header[0] != 'HTTP/1.0 404 Not Found' && @file_get_contents($youtube) !== false){
                $filename = slug($e['title']) .'-'.time().'.jpg';
                file_put_contents(public_path('uploads/video/'.$e['boss'].'/'.$filename), file_get_contents($youtube));
                Image::make(public_path('uploads/video/'.$e['boss'].'/'.$filename))->fit(800,400)->save(public_path('uploads/video/'.$e['boss'].'/small-'.$filename));
                $model->image = $filename;
            }
        }

        $model->title = $e['title'];
        $model->slug = slug($e['title']);
        $model->type = $e['type'];
        $model->category = $e['boss'];
        $model->autoplay = isset($e['autoplay']);
        $model->loop = isset($e['loop']);
        $model->mute = isset($e['mute']);
        $model->save();

        if($data){
            if($image->hasImage() && !empty($data['image'])){
                $image->remove('video/'.$e['boss'], $data['image']);
            }

            if($e['type'] == 3){
                foreach(['mp4', 'webm'] as $item){
                    $file = request()->file($item);
                    if($file && isset($data[$item]) && !empty($data[$item])){
                        if (file_exists(public_path('uploads/video/'.$e['boss'].'/' . $data[$item]))) {
                            unlink(public_path('uploads/video/'.$e['boss'].'/' . $data[$item]));
                        }
                    }
                }
            }elseif($e['type'] == 4){
                $file = request()->file('gif');
                if($file && isset($data['video_id']) && !empty($data['video_id'])){
                    if (file_exists(public_path('uploads/video/'.$e['boss'].'/' . $data['video_id']))) {
                        unlink(public_path('uploads/video/'.$e['boss'].'/' . $data['video_id']));
                    }
                }
            }elseif($e['type'] == 5){
                $file = request()->file('sound');
                if($file && isset($data['video_id']) && !empty($data['video_id'])){
                    if (file_exists(public_path('uploads/video/'.$e['boss'].'/' . $data['video_id']))) {
                        unlink(public_path('uploads/video/'.$e['boss'].'/' . $data['video_id']));
                    }
                }
            }
        }

        return $model;
    }

    public function videocategory()
    {
        return $this->belongsTo(VideoGallery::class,'category','id')->where('active',1)->orderBy('order','asc');
    }
}
