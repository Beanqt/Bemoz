<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Throne\Controller;
use App\Models\DocumentCategory;
use App\Models\DocumentItem;
use App\Models\Gallery;
use App\Models\Images;
use App\Models\Video;
use App\Models\VideoGallery;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class MediaManagerController extends Controller {
    public $zip;
    public $breadcrumbs = [];
    public $config = [
        'documents' => [
            'class' => DocumentItem::class,
            'category_class' => DocumentCategory::class,
            'namespace' => 'documentitem',
            'mimes' => ['png','jpg','jpeg','doc','docx','xls','xlsx','xlsb','csv','ppt','pptx','pdf','rar','zip','gif','ppsx','ods','odt','odt','odg','odf'],
            'cache' => [
                'documents.{id}',
                'document_items.{category}',
                'document_category.{category}',
                'document_category.folder.{category}',
            ]
        ],
        'gallery' => [
            'class' => Images::class,
            'category_class' => Gallery::class,
            'namespace' => 'gallery',
            'mimes' => ['png','jpg','jpeg','gif'],
            'cache' => [
                'gallery_images.{category}',
                'images.{id}',
            ]
        ],
        'video' => [
            'class' => Video::class,
            'category_class' => VideoGallery::class,
            'namespace' => 'video',
        ],
    ];

    public function load($type){
        if(isset($this->config[$type])){
            $datas = $this->getDatas(['folder' => 0], $type);
            $this->getBreadCrumbs(0, $type);

            $return['content'] = view('throne.widgets.media_manager.'.$type.'.index')->with('boss', 0)->with('breadcrumbs', $this->breadcrumbs)->with('folders', $datas['folders'])->with('files', $datas['files'])->render();
            return $return;
        }

        return response(trans('admin.ajax.error'), 400);
    }

    public function getDatas($e, $type){
        $config = $this->config[$type];
        $folders = $config['category_class']::orderBy('order', 'asc')->orderBy('id', 'asc');
        $files = $config['class']::orderBy('order', 'asc')->orderBy('id', 'asc');

        if(isset($e['search'])){
            $folders = $folders->where('title', 'LIKE', '%'.$e['search'].'%');
            $files = $files->where('title', 'LIKE', '%'.$e['search'].'%');
        }else{
            $folders = $folders->where('boss', $e['folder']);
            $files = $files->where('category', $e['folder']);
        }
        $folders = $folders->get();
        $files = $files->get();

        return ['folders' => isset($folders) ? $folders : [], 'files' => isset($files) ? $files : []];
    }

    public function get($type){
        $e = request()->all();

        if(isset($e['folder']) && isset($this->config[$type])){
            $datas = $this->getDatas($e, $type);
            $this->getBreadCrumbs($e['folder'], $type);

            $return['boss'] = $e['folder'];
            $return['breadcrumbs'] = $this->breadcrumbs;
            $return['content'] = view('throne.widgets.media_manager.'.$type.'.get')->with('folders', $datas['folders'])->with('files', $datas['files'])->render();
            return $return;
        }

        return response(trans('admin.ajax.error'), 400);
    }

    public function search($type){
        $e = request()->all();

        if(isset($e['search'], $e['folder']) && isset($this->config[$type])){
            if(empty($e['search'])){
                unset($e['search']);
            }
            $datas = $this->getDatas($e, $type);
            $this->getBreadCrumbs(0, $type);

            $return['boss'] = 0;
            $return['breadcrumbs'] = $this->breadcrumbs;
            $return['content'] = view('throne.widgets.media_manager.'.$type.'.get')->with('folders', $datas['folders'])->with('files', $datas['files'])->render();
            return $return;
        }

        return response(trans('admin.ajax.error'), 400);
    }

    public function manager_view(){
        $e = request()->all();
        session()->put('media_manager_view', isset($e['view']) ? ($e['view'] == 'grid' ? 1 : 2) : 1);

        return [];
    }

    public function getBreadCrumbs($boss = 0, $type, $index = 0){
        $config = $this->config[$type];
        $boss = $config['category_class']::find($boss);

        if($boss) {
            $url = route('throne.'.($boss::$name).'.folder', $boss['id']);

            $this->breadcrumbs[$index] = [
                'title' => $boss['title'],
                'id' => $boss['id'],
                'url' => $url
            ];

            if(!empty($boss['boss'])){
                $this->getBreadCrumbs($boss['boss'], $type, $index+1);
            }else{
                krsort($this->breadcrumbs);
                $this->breadcrumbs = array_values($this->breadcrumbs);
            }
        }
    }

    public function fileUpload(){
        $type = $this->getRouteParameter('type');
        $file = request()->file('file');
        $boss = request()->get('boss');
        $folder = request()->get('folder');

        if($file && isset($this->config[$type])){
            $config = $this->config[$type];
            $max_size = $type == 'gallery' ? setting('upload_image') : setting('upload_document');
            $max_size = empty($max_size) ? 104857600 : $max_size*1024*1024;

            if(!in_array(strtolower($file->getClientOriginalExtension()), $config['mimes'])){
                return response(trans('admin.alert.mimes'), 400);
            }elseif($file->getSize() > $max_size){
                return response(trans('admin.alert.size'), 400);
            }else{
                if($folder){
                    $category_model = $config['category_class'];

                    $folders = explode('/', $folder);
                    unset($folders[count($folders)-1]);

                    foreach($folders as $key => $folder){
                        $slug = slug($folder);
                        $result = $category_model::where('slug', $slug)->where('boss', $boss)->first();
                        if(!$result){
                            $model = new $category_model();
                            $model = $model->saveData([
                                'title' => $folder,
                                'slug' => $slug,
                                'boss' => $boss
                            ]);
                            $model->active = 1;
                            $model->save();

                            $boss = $model['id'];

                            if($key == 0) {
                                $return = view('throne.widgets.media_manager.'.$type.'._folder_item')->with('folder', $model)->render();
                            }
                        }else{
                            $boss = $result['id'];
                        }
                    }
                }

                $size = $file->getSize();
                $filename = str_replace('.'.$file->getClientOriginalExtension(),'',$file->getClientOriginalName());
                $basename = $filename;
                $filename = slug($filename) .'-'.time(). '.' . $file->getClientOriginalExtension();

                $class = $config['class'];
                if($class::where('category', $boss)->where('title', $basename)->first()){
                    return response(trans('admin.alert.have'), 400);
                }
                if(!file_exists(public_path('/uploads/'.$config['namespace'].'/'.$boss))) {
                    mkdir(public_path('/uploads/'.$config['namespace'].'/'.$boss));
                }
                $path = public_path('/uploads/'.$config['namespace'].'/'.$boss.'/'.$filename);

                if($type == 'gallery'){
                    $image_size = getimagesize($file->getRealPath());
                    $path_small = public_path('/uploads/'.$config['namespace'].'/'.$boss.'/small-' . $filename);

                    if($image_size[0] >= $image_size[1]){
                        $width = 800;
                        $height = 500;
                    }else{
                        $width = 700;
                        $height = 900;
                    }

                    Image::make($file->getRealPath())->orientate()->fit($width, $height)->save($path_small);
                    Image::make($file->getRealPath())->orientate()->save($path);
                }else{
                    $file->move(public_path('/uploads/'.$config['namespace'].'/'.$boss), $path);
                }

                $model = new $class();
                $model->title = $basename;
                $model->slug = slug($basename);

                if($type == 'documents'){
                    $model->file = $filename;
                    $model->size = number_format($size/1024/1024, 2, '.','');
                }elseif($type == 'gallery'){
                    $model->image = $filename;
                    $model->image_crop = json_encode(['size' => ['width' => $width, 'height' => $height]]);

                }
                $model->category = $boss;
                $model->active = 1;
                $model->save();

                $this->model = $config['class'];
                $this->deleteCache = $config['cache'];
                $this->deleteCache($model);

                if(isset($return)){
                    return $return;
                }elseif($folder == ''){
                    return view('throne.widgets.media_manager.'.$type.'._item')->with('boss', $boss)->with('item', $model);
                }
                return '';
            }
        }

        return response(trans('admin.ajax.error'), 400);
    }

    public function downloadZip($type = '', $boss = 0){
        if(isset($this->config[$type])){
            $config = $this->config[$type];
            if(file_exists(storage_path('zip/download.zip'))) {
                unlink(storage_path('zip/download.zip'));
            }

            $this->zip = new \ZipArchive();
            $this->zip->open(storage_path('zip/download.zip'), \ZipArchive::CREATE);
            $this->addFolder($boss, $type, $config);
            if($this->zip->numFiles == 0){
                $this->zip->addFromString("empty_folder.txt", "");
            }
            $this->zip->close();

            return Response::download(storage_path('zip/download.zip'));
        }

        session()->put('error', trans('admin.ajax.error'));
        return redirect()->back();
    }

    public function addFolder($boss = 0, $type, $config, $folder_path = ''){
        $class = $config['class'];

        $sub = $config['category_class']::where('boss', $boss)->get();
        $files = $class::where('category', $boss)->get();

        foreach($files as $file){
            if($type == 'documents'){
                $this->zip->addFile(public_path('uploads/'.$config['namespace'].'/'.$file['category'].'/'.$file['file']), $folder_path.$file['file']);
            }else{
                $this->zip->addFile(public_path('uploads/'.$config['namespace'].'/'.$file['category'].'/'.$file['image']), $folder_path.$file['image']);
            }
        }
        foreach($sub as $folder){
            $this->zip->addEmptyDir($folder_path.$folder['title']);
            $this->addFolder($folder['id'], $type, $config, $folder_path.$folder['title'].'/');
        }
    }

    public function paste($type = '', $boss = 0){
        $e = request()->get();

        if(isset($e['folders'], $e['documents'])){
            $config = $this->config[$type];
            $documents = json_decode($e['documents'], true);
            $folders = json_decode($e['folders'], true);

            $folders = $config['category_class']::whereIn('id', $folders)->where('id', '!=', $boss)->where('boss', '!=', $boss)->get();
            $documents = $config['class']::whereIn('id', $documents)->where('category', '!=', $boss)->get();

            foreach($folders as $item){
                $item->boss = $boss;
                $item->save();
            }

            foreach($documents as $item){
                if(!is_dir(public_path('uploads/'.$config['namespace'].'/'.$boss))){
                    mkdir(public_path('uploads/'.$config['namespace'].'/'.$boss));
                }

                if($type != 'documents'){
                    if(!empty($item['image']) && file_exists(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['image']))){
                        copy(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['image']), public_path('uploads/'.$config['namespace'].'/'.$boss.'/'.$item['image']));
                        unlink(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['image']));
                    }
                    if(!empty($item['image']) && file_exists(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/small-'.$item['image']))){
                        copy(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/small-'.$item['image']), public_path('uploads/'.$config['namespace'].'/'.$boss.'/small-'.$item['image']));
                        unlink(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/small-'.$item['image']));
                    }
                }

                if($type == 'documents'){
                    if(!is_dir(public_path('uploads/'.$config['namespace'].'/'.$boss.'/image'))){
                        mkdir(public_path('uploads/'.$config['namespace'].'/'.$boss.'/image'));
                    }

                    if(!empty($item['image']) && file_exists(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/image/'.$item['image']))){
                        copy(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/image/'.$item['image']), public_path('uploads/'.$config['namespace'].'/'.$boss.'/image/'.$item['image']));
                        unlink(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/image/'.$item['image']));
                    }
                    if(!empty($item['image']) && file_exists(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/image/small-'.$item['image']))){
                        copy(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/image/small-'.$item['image']), public_path('uploads/'.$config['namespace'].'/'.$boss.'/image/small-'.$item['image']));
                        unlink(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/image/small-'.$item['image']));
                    }
                    if(!empty($item['file']) && file_exists(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['file']))){
                        copy(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['file']), public_path('uploads/'.$config['namespace'].'/'.$boss.'/'.$item['file']));
                        unlink(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['file']));
                    }
                }elseif($type == 'video'){

                    if(!empty($item['image']) && file_exists(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['image']))){
                        copy(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['image']), public_path('uploads/'.$config['namespace'].'/'.$boss.'/'.$item['image']));
                        unlink(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['image']));
                    }
                    if(!empty($item['image']) && file_exists(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/small-'.$item['image']))){
                        copy(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/small-'.$item['image']), public_path('uploads/'.$config['namespace'].'/'.$boss.'/small-'.$item['image']));
                        unlink(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/small-'.$item['image']));
                    }

                    if(!empty($item['mp4']) && file_exists(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['mp4']))){
                        copy(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['mp4']), public_path('uploads/'.$config['namespace'].'/'.$boss.'/'.$item['mp4']));
                        unlink(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['mp4']));
                    }
                    if(!empty($item['webm']) && file_exists(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['webm']))){
                        copy(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['webm']), public_path('uploads/'.$config['namespace'].'/'.$boss.'/'.$item['webm']));
                        unlink(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['webm']));
                    }

                    if(in_array($item['type'], [4,5])){
                        if(!empty($item['video_id']) && file_exists(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['video_id']))){
                            copy(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['video_id']), public_path('uploads/'.$config['namespace'].'/'.$boss.'/'.$item['video_id']));
                            unlink(public_path('uploads/'.$config['namespace'].'/'.$item['category'].'/'.$item['video_id']));
                        }
                    }
                }

                if($document = $config['class']::where('title', $item->title)->where('category', $boss)->count()){
                    $item->title = $item->title.' - '.microtime(true);
                    $item->slug = slug($item->title);
                }
                $item->category = $boss;
                $item->save();
            }

            request()->merge(['folder' => $boss]);
            return $this->get($type);
        }

        return response(trans('admin.ajax.error'), 400);
    }

    public function afterDeleted(){
        return ['return' => true, 'msg' => trans('admin.alert.delete')];
    }
}
