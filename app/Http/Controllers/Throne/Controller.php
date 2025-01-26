<?php namespace App\Http\Controllers\Throne;

use App\Models\Admins;
use App\Models\Cache;
use App\Models\Languages;
use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

abstract class Controller extends BaseController
{
    public $boss;
    public $lang;
    public $stats;
    public $all = [];

    public function getLang(){
        if(!session('moduleLang')){
            session()->put('moduleLang', 'hu');
        }

        $lang = Languages::where('locale', session('moduleLang'))->first();
        $this->lang = $lang['id'];
        View::share('current_lang', $lang);
    }

    public function getAll($input, $statistics = true, $all = false)
    {
        $data = $this->model;
        $data = $this->queryAddition($data);
        $data = $this->check($input, $data);

        if(isset($this->set_stats) && $statistics){
            foreach($this->set_stats as $key => $stat){
                $this->stats[$key] = call_user_func($stat, clone $data);
            }
        }

        return $all ? $data->get() : $data->paginate(25);
    }

    public function index()
    {
        if(isset($this->multi_order)){
            $this->all = $this->getAll([], false, true)->toArray();

            View::share($this->default, $this->getOrderHtml());
        }else{
            Paginator::currentPageResolver(function() {
                return session('page_'.$this->default);
            });

            $data = $this->getAll(session('log_input_'.$this->default));
            View::share($this->default, $data);
        }

        if(method_exists($this, 'lists')){
            call_user_func([$this, 'lists']);
        }
        if(!empty($this->stats)){
            foreach($this->stats as $key => $stat){
                View::share($key, $stat);
            }
        }
        if(Route::has('throne.'.$this->default.'.trash') && in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this->model))){
            $trash = $this->model;
            $trash = $this->queryAddition($trash);

            View::share('trash', $trash->onlyTrashed()->count());
        }

        return $this->renderView('index');
    }

    public function page()
    {
        session()->put('page_'.$this->default, isset($_GET['page']) ? $_GET['page'] : 1);
        $data = $this->getAll(session('log_input_'.$this->default), false);

        View::share($this->default, $data);
        return $this->renderView('content');
    }

    public function api()
    {
        $e = request()->all();

        session()->put('page_'.$this->default, isset($_GET['page']) ? $_GET['page'] : 1);
        $data = $this->getAll($e);

        $return = [];
        if(count($data) == 0) {
            $return['return'] = false;
            $return['msg'] = trans('admin.'.$this->default.'.alerts.notfound');
        }else {
            $return['return'] = true;

            View::share($this->default, $data);
            $return['content'] = $this->renderView('content', [], true);
        }

        if(!empty($this->stats)){
            foreach($this->stats as $key => $stat){
                $return['stat'][$key] = $stat;
            }
        }

        session()->put('log_input_'.$this->default, $e);

        return $return;
    }

    public function check($e, $sql)
    {
        if(!is_array($e)) {
            return $sql;
        }
        $exception = isset($this->check_exception) ? $this->check_exception : [];

        unset($e['_token']);

        if(isset($this->check)){
            call_user_func($this->check, $sql, $e);
        }

        foreach($e as $key => $item){
            if(!empty($item) && !in_array($key, $exception)){
                $array = explode('_', $key);

                if(count($array) > 1){
                    $relation = $this->model->{$array[0]}();
                    $name = class_basename($relation);

                    if($name == 'BelongsTo'){
                        $column = $relation->getForeignKey();

                        $sql = $sql->where($column, $item);
                    }elseif($name == 'BelongsToMany'){
                        $pivot_array = explode('.', $relation->getQualifiedForeignPivotKeyName());
                        $pivotTable = current($pivot_array);

                        $data = DB::table($pivotTable)->where($relation->getRelatedPivotKeyName(), $item)->pluck($relation->getForeignPivotKeyName())->all();
                        $sql = $sql->whereIn('id', $data);
                    }elseif($name == 'HasMany'){
                        $sql = $sql->whereHas($array[0], function($query) use($array, $item){
                            return $query->where($array[1], 'LIKE', '%'.$item.'%');
                        });
                    }
                }else{
                    $key = $array[0];
                    if($key == "created_at"){
                        $dateArray = explode('|',$item);

                        if(count($dateArray) > 1){
                            $start = getFilterDate($dateArray[0]);
                            $to = getFilterDate($dateArray[1], true);
                        }else{
                            $start = getFilterDate($item);
                            $to = getFilterDate($item, true);
                        }

                        $sql = $sql->where(function($query) use($start, $to){
                            $query->where('created_at','>=',$start)->where('created_at', '<=', $to);
                        });
                    }elseif(is_numeric($item)){
                        $sql = $sql->where($key, $item);
                    }else{
                        $sql = $sql->where($key, 'LIKE', '%' . $item . '%');
                    }
                }
            }
        }

        return $sql;
    }

    public function create() {
        if(request()->isMethod('post')) {
            $e = request()->all();
            if(isset($this->lang)){
                $e['lang'] = $this->lang;
            }
            if(isset($this->boss)){
                $e[$this->boss[0]] = array_key_exists(2, $this->boss) ? $this->boss[2] : $this->boss[1];
            }

            if($this->model->isValid($e)){
                $model = $this->model->saveData($e);

                return $this->checkRedirect($e['submit'], $model->id);
            }

            foreach($e as $key => $value){
                $e[$key] = !is_array($value) && is_array(json_decode($value, true)) ? json_decode($value, true) : $value;
            }

            if(isset($this->clear_inputs)){
                foreach($this->clear_inputs as $name){
                    unset($e[$name]);
                }
            }
            View::share('data', $e);
        }

        if(method_exists($this, 'creation')){
            call_user_func([$this, 'creation']);
        }

        return $this->renderView('new', $this->model->validator);
    }

    public function edit() {
        $id = $this->getRouteParameter('id');
        $data = $this->model->find($id);

        if($data) {
            if(isset($this->archive)){
                $this->archive($this->getRouteParameter('archived'), $id, function() use($data){
                    if(isset($this->edit)){
                        call_user_func($this->edit, $data);
                    }

                    View::share('data', $data);
                });
            }else{
                if(isset($this->edit)){
                    call_user_func($this->edit, $data);
                }

                View::share('data', $data);
            }

            View::share('edit', $id);

            if (request()->isMethod('post')) {
                $e = request()->all();
                if(isset($this->lang)){
                    $e['lang'] = $this->lang;
                }
                if(isset($this->boss)){
                    $e[$this->boss[0]] = array_key_exists(2, $this->boss) ? $this->boss[2] : $this->boss[1];
                }

                if($this->model->isValid($e, $data)){
                    $model = $this->model->saveData($e, $data);

                    $this->deleteCache($model);
                    return $this->checkRedirect($e['submit'], $model->id);
                }

                foreach($e as $key => $value){
                    $e[$key] = !is_array($value) && is_array(json_decode($value, true)) ? json_decode($value, true) : $value;
                }

                if(isset($this->clear_inputs)){
                    foreach($this->clear_inputs as $name){
                        $e[$name] = $data[$name];
                    }
                }
                View::share('data', $e);
            }

            if(method_exists($this, 'update')){
                call_user_func_array([$this, 'update'], [$data]);
            }
            return $this->renderView('edit', $this->model->validator);
        }

        return request()->ajax() ? response(trans('admin.ajax.error'), 400) : redirect()->route('throne.'.$this->default, isset($this->boss) ? $this->boss[1] : []);
    }

    public function status()
    {
        $return = [];
        $id = $this->getRouteParameter('id');
        $type = isset($this->status_type) ? $this->status_type : 'active';

        $model = $this->model->find($id);
        if($model) {
            $model->{$type} = !$model[$type];
            $model->save();

            $this->deleteCache($model);

            $return['return'] = true;
            $return['active'] = $model->{$type} ? 1 : 0;
            $return['msg'] = trans('admin.alert.success_status');
        } else {
            $return['return'] = false;
            $return['msg'] = trans('admin.alert.error_status');
        }

        return Response::json($return);
    }

    public function featured() {
        $this->status_type = 'featured';

        return $this->status();
    }

    public function fileUpload(){
        $file = request()->file('file');

        $options = [
            'extensions' => ['png','jpg','jpeg','gif'],
            'max' => 104857600,
            'crop' => false
        ];

        if(isset($this->uploads)){
            $options = array_merge($options, $this->uploads);
        }

        if($file){
            if(!in_array(strtolower($file->getClientOriginalExtension()), $options['extensions'])){
                return response(trans('admin.alert.mimes'), 400);
            }elseif($file->getSize() > $options['max']){
                return response(trans('admin.alert.size'), 400);
            }else{
                $filename = str_replace('.'.$file->getClientOriginalExtension(),'',$file->getClientOriginalName());
                $basename = $filename;
                $filename = slug($filename) .'-'.time().'.'.$file->getClientOriginalExtension();

                if(!file_exists(public_path('uploads/'.$this->default))) {
                    mkdir(public_path('uploads/'.$this->default));
                }

                if($options['crop']){
                    $path_small = public_path('uploads/'.$this->default.'/small-' . $filename);
                    Image::make($file->getRealPath())->fit($options['crop']['width'], $options['crop']['height'])->save($path_small);
                }

                $path = public_path('uploads/'.$this->default.'/'.$filename);
                $file->move(public_path('uploads/'.$this->default), $path);

                if(isset($this->lang)){
                    $e['lang'] = $this->lang;
                }
                if(isset($this->boss)){
                    $e[$this->boss[0]] = array_key_exists(2, $this->boss) ? $this->boss[2] : $this->boss[1];
                }

                $e['title'] = $basename;
                $e['filename'] = $filename;

                $model = $this->model->saveData($e);

                View::share('item', $model);
                return $this->renderView('_item');
            }
        }

        return response(trans('admin.ajax.error'), 400);
    }

    public function delete()
    {
        $id = $this->getRouteParameter('id');

        $model = $this->model->find($id);
        if($model){
            if(isset($model->active)){
                $this->model->where('id', $id)->update(['active' => 0]);
            }

            $this->deleteCache($model);
            $model->delete();
        }

        if(method_exists($this, 'afterDeleted')){
            return call_user_func([$this, 'afterDeleted']);
        }

        session()->flash('success', trans('admin.alert.delete'));
        session()->flash('change_url', route('throne.'.$this->default, isset($this->boss) ? $this->boss[1] : []));
        return redirect()->route('throne.'.$this->default, isset($this->boss) ? $this->boss[1] : []);
    }

    public function sort()
    {
        if (request()->isMethod('post')) {
            $e = request()->all();

            if (!empty($e['nested'])) {
                $this->sortMenu(json_decode($e['nested'], true));

                Logs::saveData([
                    'type' => $this->default,
                    'element_id' => 0,
                    'action' => 5,
                    'data' => json_decode($e['nested'], true)
                ]);

                $this->deleteCache('sort');

                session()->flash('change_url', route('throne.'.$this->default, isset($this->boss) ? $this->boss[1] : []));
                session()->flash('success', trans('admin.alert.save'));
            } else {
                session()->flash('error', trans('admin.alert.no_change_order'));
            }
        } else {
            if(!isset($this->multi_order)){
                $data = $this->getAll(session('log_input_'.$this->default), false, true);
            }else{
                $this->all = $this->getAll([], false, true)->toArray();
                $data = $this->getOrderHtml(0, true);
            }

            View::share($this->default, $data);
            return $this->renderView('sort');
        }
        return redirect()->route('throne.'.$this->default, isset($this->boss) ? $this->boss[1] : []);
    }

    public function sortMenu($list, $order = 0, $boss = 0)
    {
        foreach ($list as $item) {
            $order++;
            $model = $this->model->find($item['id']);
            if(isset($this->multi_order)){
                $model->boss = $boss;
            }
            $model->order = $order;
            $model->save();

            if(array_key_exists("children",$item)) {
                $this->sortMenu($item['children'],$order,$item['id']);
            }
        }
    }

    public function getOrderHtml($boss = 0, $orderPage = false){
        $data = array_filter($this->all, function($item) use($boss){
            return $item['boss'] == $boss;
        });

        if(count($data)){
            View::share('orderPage', $orderPage);
            View::share('data', $data);

            return $this->renderView('sort_items', [], true);
        }

        return '';
    }

    public function export() {
        if(!isset($this->export)){return false;}

        $file = $this->export['name'].'-export-'.date('Y-m-d-H\h-i\m').'.xls';
        $data = $this->getAll(session('log_input_'.$this->default), false, true);
        $header = [];

        foreach($this->export['columns'] as $column){
            $header[$column] = trans('admin.'.$this->default.'.table.'.$column);
        }

        foreach($data as $key => $item){
            if(isset($this->export['item'])){
                call_user_func($this->export['item'], $item);
            }

            $item = $item->only($this->export['columns']);
            foreach($this->export['columns'] as $column){
                $item[$header[$column]] = preg_replace('/[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0077}\x{E006C}\x{E0073}\x{E007F})|[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0073}\x{E0063}\x{E0074}\x{E007F})|[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0065}\x{E006E}\x{E0067}\x{E007F})|[\x{1F3F4}](?:\x{200D}\x{2620}\x{FE0F})|[\x{1F3F3}](?:\x{FE0F}\x{200D}\x{1F308})|[\x{0023}\x{002A}\x{0030}\x{0031}\x{0032}\x{0033}\x{0034}\x{0035}\x{0036}\x{0037}\x{0038}\x{0039}](?:\x{FE0F}\x{20E3})|[\x{1F441}](?:\x{FE0F}\x{200D}\x{1F5E8}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F466})|[\x{1F469}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F469})|[\x{1F469}\x{1F468}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F468})|[\x{1F469}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F469})|[\x{1F469}\x{1F468}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F468})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F9B0})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B0})|[\x{1F575}\x{1F3CC}\x{26F9}\x{1F3CB}](?:\x{FE0F}\x{200D}\x{2640}\x{FE0F})|[\x{1F575}\x{1F3CC}\x{26F9}\x{1F3CB}](?:\x{FE0F}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FF}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FE}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FD}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FC}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FB}\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F9B8}\x{1F9B9}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F9DE}\x{1F9DF}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F46F}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93C}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{200D}\x{2640}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FF}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FE}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FD}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FC}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{1F3FB}\x{200D}\x{2642}\x{FE0F})|[\x{1F46E}\x{1F9B8}\x{1F9B9}\x{1F482}\x{1F477}\x{1F473}\x{1F471}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F9DE}\x{1F9DF}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F46F}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93C}\x{1F93D}\x{1F93E}\x{1F939}](?:\x{200D}\x{2642}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{1F3FF}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FE}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FD}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FC}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{1F3FB}\x{200D}\x{2695}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2695}\x{FE0F})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FF})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FE})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FD})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FC})|[\x{1F476}\x{1F9D2}\x{1F466}\x{1F467}\x{1F9D1}\x{1F468}\x{1F469}\x{1F9D3}\x{1F474}\x{1F475}\x{1F46E}\x{1F575}\x{1F482}\x{1F477}\x{1F934}\x{1F478}\x{1F473}\x{1F472}\x{1F9D5}\x{1F9D4}\x{1F471}\x{1F935}\x{1F470}\x{1F930}\x{1F931}\x{1F47C}\x{1F385}\x{1F936}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F647}\x{1F926}\x{1F937}\x{1F486}\x{1F487}\x{1F6B6}\x{1F3C3}\x{1F483}\x{1F57A}\x{1F9D6}\x{1F9D7}\x{1F9D8}\x{1F6C0}\x{1F6CC}\x{1F574}\x{1F3C7}\x{1F3C2}\x{1F3CC}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{26F9}\x{1F3CB}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93D}\x{1F93E}\x{1F939}\x{1F933}\x{1F4AA}\x{1F9B5}\x{1F9B6}\x{1F448}\x{1F449}\x{261D}\x{1F446}\x{1F595}\x{1F447}\x{270C}\x{1F91E}\x{1F596}\x{1F918}\x{1F919}\x{1F590}\x{270B}\x{1F44C}\x{1F44D}\x{1F44E}\x{270A}\x{1F44A}\x{1F91B}\x{1F91C}\x{1F91A}\x{1F44B}\x{1F91F}\x{270D}\x{1F44F}\x{1F450}\x{1F64C}\x{1F932}\x{1F64F}\x{1F485}\x{1F442}\x{1F443}](?:\x{1F3FB})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F8}\x{1F1F9}\x{1F1FA}](?:\x{1F1FF})|[\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F0}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1FA}](?:\x{1F1FE})|[\x{1F1E6}\x{1F1E8}\x{1F1F2}\x{1F1F8}](?:\x{1F1FD})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F7}\x{1F1F9}\x{1F1FF}](?:\x{1F1FC})|[\x{1F1E7}\x{1F1E8}\x{1F1F1}\x{1F1F2}\x{1F1F8}\x{1F1F9}](?:\x{1F1FB})|[\x{1F1E6}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1ED}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F7}\x{1F1FB}](?:\x{1F1FA})|[\x{1F1E6}\x{1F1E7}\x{1F1EA}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FE}](?:\x{1F1F9})|[\x{1F1E6}\x{1F1E7}\x{1F1EA}\x{1F1EC}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F7}\x{1F1F8}\x{1F1FA}\x{1F1FC}](?:\x{1F1F8})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EB}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F0}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1F7})|[\x{1F1E6}\x{1F1E7}\x{1F1EC}\x{1F1EE}\x{1F1F2}](?:\x{1F1F6})|[\x{1F1E8}\x{1F1EC}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F3}](?:\x{1F1F5})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1EE}\x{1F1EF}\x{1F1F2}\x{1F1F3}\x{1F1F7}\x{1F1F8}\x{1F1F9}](?:\x{1F1F4})|[\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}](?:\x{1F1F3})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F4}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FF}](?:\x{1F1F2})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1EE}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1F1})|[\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1ED}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FD}](?:\x{1F1F0})|[\x{1F1E7}\x{1F1E9}\x{1F1EB}\x{1F1F8}\x{1F1F9}](?:\x{1F1EF})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EB}\x{1F1EC}\x{1F1F0}\x{1F1F1}\x{1F1F3}\x{1F1F8}\x{1F1FB}](?:\x{1F1EE})|[\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1ED})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EA}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}](?:\x{1F1EC})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F9}\x{1F1FC}](?:\x{1F1EB})|[\x{1F1E6}\x{1F1E7}\x{1F1E9}\x{1F1EA}\x{1F1EC}\x{1F1EE}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F7}\x{1F1F8}\x{1F1FB}\x{1F1FE}](?:\x{1F1EA})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1EE}\x{1F1F2}\x{1F1F8}\x{1F1F9}](?:\x{1F1E9})|[\x{1F1E6}\x{1F1E8}\x{1F1EA}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F8}\x{1F1F9}\x{1F1FB}](?:\x{1F1E8})|[\x{1F1E7}\x{1F1EC}\x{1F1F1}\x{1F1F8}](?:\x{1F1E7})|[\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F6}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}\x{1F1FF}](?:\x{1F1E6})|[\x{00A9}\x{00AE}\x{203C}\x{2049}\x{2122}\x{2139}\x{2194}-\x{2199}\x{21A9}-\x{21AA}\x{231A}-\x{231B}\x{2328}\x{23CF}\x{23E9}-\x{23F3}\x{23F8}-\x{23FA}\x{24C2}\x{25AA}-\x{25AB}\x{25B6}\x{25C0}\x{25FB}-\x{25FE}\x{2600}-\x{2604}\x{260E}\x{2611}\x{2614}-\x{2615}\x{2618}\x{261D}\x{2620}\x{2622}-\x{2623}\x{2626}\x{262A}\x{262E}-\x{262F}\x{2638}-\x{263A}\x{2640}\x{2642}\x{2648}-\x{2653}\x{2660}\x{2663}\x{2665}-\x{2666}\x{2668}\x{267B}\x{267E}-\x{267F}\x{2692}-\x{2697}\x{2699}\x{269B}-\x{269C}\x{26A0}-\x{26A1}\x{26AA}-\x{26AB}\x{26B0}-\x{26B1}\x{26BD}-\x{26BE}\x{26C4}-\x{26C5}\x{26C8}\x{26CE}-\x{26CF}\x{26D1}\x{26D3}-\x{26D4}\x{26E9}-\x{26EA}\x{26F0}-\x{26F5}\x{26F7}-\x{26FA}\x{26FD}\x{2702}\x{2705}\x{2708}-\x{270D}\x{270F}\x{2712}\x{2714}\x{2716}\x{271D}\x{2721}\x{2728}\x{2733}-\x{2734}\x{2744}\x{2747}\x{274C}\x{274E}\x{2753}-\x{2755}\x{2757}\x{2763}-\x{2764}\x{2795}-\x{2797}\x{27A1}\x{27B0}\x{27BF}\x{2934}-\x{2935}\x{2B05}-\x{2B07}\x{2B1B}-\x{2B1C}\x{2B50}\x{2B55}\x{3030}\x{303D}\x{3297}\x{3299}\x{1F004}\x{1F0CF}\x{1F170}-\x{1F171}\x{1F17E}-\x{1F17F}\x{1F18E}\x{1F191}-\x{1F19A}\x{1F201}-\x{1F202}\x{1F21A}\x{1F22F}\x{1F232}-\x{1F23A}\x{1F250}-\x{1F251}\x{1F300}-\x{1F321}\x{1F324}-\x{1F393}\x{1F396}-\x{1F397}\x{1F399}-\x{1F39B}\x{1F39E}-\x{1F3F0}\x{1F3F3}-\x{1F3F5}\x{1F3F7}-\x{1F3FA}\x{1F400}-\x{1F4FD}\x{1F4FF}-\x{1F53D}\x{1F549}-\x{1F54E}\x{1F550}-\x{1F567}\x{1F56F}-\x{1F570}\x{1F573}-\x{1F57A}\x{1F587}\x{1F58A}-\x{1F58D}\x{1F590}\x{1F595}-\x{1F596}\x{1F5A4}-\x{1F5A5}\x{1F5A8}\x{1F5B1}-\x{1F5B2}\x{1F5BC}\x{1F5C2}-\x{1F5C4}\x{1F5D1}-\x{1F5D3}\x{1F5DC}-\x{1F5DE}\x{1F5E1}\x{1F5E3}\x{1F5E8}\x{1F5EF}\x{1F5F3}\x{1F5FA}-\x{1F64F}\x{1F680}-\x{1F6C5}\x{1F6CB}-\x{1F6D2}\x{1F6E0}-\x{1F6E5}\x{1F6E9}\x{1F6EB}-\x{1F6EC}\x{1F6F0}\x{1F6F3}-\x{1F6F9}\x{1F910}-\x{1F93A}\x{1F93C}-\x{1F93E}\x{1F940}-\x{1F945}\x{1F947}-\x{1F970}\x{1F973}-\x{1F976}\x{1F97A}\x{1F97C}-\x{1F9A2}\x{1F9B0}-\x{1F9B9}\x{1F9C0}-\x{1F9C2}\x{1F9D0}-\x{1F9FF}]/u', '', $item[$column]);
                unset($item[$column]);
            }

            $data[$key] = $item;
        }

        Logs::saveData([
            'type' => $this->default,
            'element_id' => 0,
            'action' => 6,
            'data' => []
        ]);

        if(!isset($this->export['zip'])){
            return $data->downloadExcel($file, null, true);
        }

        $data->storeExcel('exports/'.$file, null, null, false);

        if(!file_exists(storage_path('zip'))) {
            @mkdir(storage_path('zip'), 0777, true);
        }
        if(file_exists(storage_path('zip/'.$this->export['name'].'.zip'))){
            unlink(storage_path('zip/'.$this->export['name'].'.zip'));
        }

        $zip = new \ZipArchive();
        $zip->open(storage_path('zip/'.$this->export['name'].'.zip'), \ZipArchive::CREATE);
        $zip->addFile(storage_path('app/exports/'.$file), $file);

        if(is_callable($this->export['zip'])){
            call_user_func_array($this->export['zip'], [$zip, $data]);
        }

        $zip->close();

        return Response::download(storage_path('zip/'.$this->export['name'].'.zip'));
    }

    public function trash()
    {
        $data = $this->model->onlyTrashed();
        $data = $this->queryAddition($data);
        $data = $data->get();

        View::share($this->default, $data);
        return $this->renderView('trash');
    }

    public function trashRestore()
    {
        $id = $this->getRouteParameter('id');

        $this->model->onlyTrashed()->find($id);
        $this->model->where('id', $id)->onlyTrashed()->restore();

        session()->flash('success', trans('admin.alert.delete_restore'));
        session()->flash('change_url', route('throne.'.$this->default.'.trash', isset($this->boss) ? $this->boss[1] : []));
        return redirect()->route('throne.'.$this->default.'.trash', isset($this->boss) ? $this->boss[1] : []);
    }

    public function trashDelete()
    {
        $id = $this->getRouteParameter('id');
        $model = $this->model->onlyTrashed()->find($id);
        $this->model->where('id', $id)->onlyTrashed()->forceDelete();

        if(isset($model->seo)){
            if(isset($model->seo['image']) && !empty($model->seo['image'])){
                if(file_exists(public_path('uploads/seo/'.$model['image']))){
                    unlink(public_path('uploads/seo/'.$model['image']));
                }
                if(file_exists(public_path('uploads/seo/small-'.$model['image']))){
                    unlink(public_path('uploads/seo/small-'.$model['image']));
                }
            }
            $model->seo->delete();
        }
        if(isset($model['image']) && !empty($model['image'])){
            if(file_exists(public_path('uploads/'.$this->default.'/'.$model['image']))){
                unlink(public_path('uploads/'.$this->default.'/'.$model['image']));
            }
            if(file_exists(public_path('uploads/'.$this->default.'/small-'.$model['image']))){
                unlink(public_path('uploads/'.$this->default.'/small-'.$model['image']));
            }
        }

        if(isset($this->delete_files)){
            foreach($this->delete_files as $key => $item){
                $key = is_array($item) ? $key : $item;
                $path = isset($item['path']) ? $item['path'] : '';
                $small = isset($item['small']) ? true : false;

                if(!empty($model[$key]) && file_exists(public_path('uploads/'.$this->default.'/'.$path.$model[$key]))){
                    unlink(public_path('uploads/'.$this->default.'/'.$path.$model[$key]));
                }
                if($small && file_exists(public_path('uploads/'.$this->default.'/'.$path.'small-'.$model[$key]))){
                    unlink(public_path('uploads/'.$this->default.'/'.$path.'small-'.$model[$key]));
                }
            }
        }

        if(method_exists($this, 'afterForceDelete')){
            call_user_func_array([$this, 'afterForceDelete'], [$model]);
        }

        session()->flash('success', trans('admin.alert.delete_force'));
        session()->flash('change_url', route('throne.'.$this->default.'.trash', isset($this->boss) ? $this->boss[1] : []));
        return redirect()->route('throne.'.$this->default.'.trash', isset($this->boss) ? $this->boss[1] : []);
    }

    public function deleteCache($model)
    {
        if(isset($this->deleteCache)) {
            foreach($this->deleteCache as $item) {
                $name = $item;

                if(isset($this->lang)) {
                    $name = str_replace('{main_lang}', $this->lang, $name);
                }

                preg_match_all('/{(.*?)}/', $name, $matches);

                foreach($matches[0] as $key => $match) {
                    if($model == 'sort') {
                        $elements = $this->model;
                        $elements = $this->queryAddition($elements);
                        $elements = $elements->pluck($matches[1][$key])->all();

                        foreach($elements as $item) {
                            $element_name = str_replace($match, $item, $name);
                            Cache::forget($element_name);
                        }
                    }else {
                        $name = str_replace($match, $model[$matches[1][$key]], $name);
                    }
                }

                Cache::forget($name);
            }
        }
        if(method_exists($this, 'clearCache')){
            call_user_func([$this, 'clearCache']);
        }
    }

    public function archive($id, $element_id, $function)
    {
        if ($id) {
            $archive = Logs::find($id);
            $archive = json_decode($archive['data'], true);
            if(array_key_exists('content', $archive)){
                $archive['layout'] = json_decode($archive['content'], true);
            }

            View::share('archive_id', $id);
            View::share('data', $archive);
        } else {
            call_user_func($function);
        }
        $archived = Logs::where('element_id', $element_id)->where('type', $this->default)->whereIn('action', [1,2])->with('users')->orderBy('id', 'desc')->get();
        View::share('archived', $archived);
    }

    public function checkRedirect($submit, $id)
    {
        session()->flash('success', trans('admin.alert.save'));

        if($submit == 1){
            $route = route('throne.'.$this->default.'.edit', isset($this->boss) ? [$this->boss[1], $id] : $id);
        }elseif($submit == 3){
            $route = route('throne.'.$this->default.'.new', isset($this->boss) ? $this->boss[1] : []);
        }elseif($submit == 4){
            $route = route('throne.'.$this->default.'.edit', isset($this->boss) ? [$this->boss[1], $id] : $id);
            session()->flash('show', $this->preview($id, true));
        }else{
            $route = route('throne.'.$this->default, isset($this->boss) ? $this->boss[1] : []);
        }

        if(url()->full() != $route){
            session()->flash('change_url', $route);
        }
        return redirect()->to($route);
    }

    public function getRouteParameter($name = 'boss'){
        $parameters = Route::current()->parameters();

        return array_key_exists($name, $parameters) ? $parameters[$name] : null;
    }

    public function queryAddition($sql){
        if(isset($this->lang)) {
            $sql = $sql->where('lang', $this->lang);
        }
        if(isset($this->boss)) {
            $sql = $sql->where($this->boss[0], array_key_exists(2,$this->boss) ? $this->boss[2] : $this->boss[1]);
        }
        if(isset($this->query)){
            $sql = call_user_func($this->query, $sql);
        }
        $order[0] = isset($this->order[0]) ? $this->order[0] : 'id';
        $order[1] = isset($this->order[1]) ? $this->order[1] : 'desc';
        $sql = $sql->orderBy($order[0], $order[1]);

        return $sql;
    }

    public function renderView($template, $errors = [], $render = false){
        if(view()->exists('throne.layouts.'.$this->default.'.'.$template)){
            $template = 'throne.layouts.'.$this->default.'.'.$template;
        }else{
            $template = 'throne.templates.'.$template;
        }

        $view = $this->view($template, $errors);
        session()->save();

        if($render && isset($view['content'])){
            return isset($view['content']) ? $view['content'] : $view;
        }

        return request()->ajax() ? json_encode($view) : $view;
    }

    public function view($template, $errors = []){
        $notify = [];

        if(session('success')){
            $notify['success'] = session('success');
        }
        if(session('info')){
            $notify['info'] = session('info');
        }
        if(session('error')){
            $notify['error'] = session('error');
        }

        View::share('service', $this);
        $array = ['content' => view($template)->withErrors($errors)->render(), 'notify' => $notify, 'url' => session('change_url'), 'reload' => session('reload')];

        return request()->ajax() ? $array : $array['content'];
    }
}
