<?php namespace App\Http\Controllers\Throne;

use App\Models\Languages;
use App\Models\Logs;
use App\Models\Translates;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Waavi\Translation\Facades\TranslationCache;

class LanguagesController extends Controller
{
    public $locale;
    public $translations = [];
    public $translate = Translates::class;
    public $deleteCache = [
        'languages',
    ];

    public function __construct(Languages $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->order = ['order','asc'];
    }

    public function publish(){
        $this->sync();

        session()->flash('success', trans('admin.alert.savePublish'));

        Logs::saveData([
            'type' => $this->default,
            'element_id' => 0,
            'action' => 9,
            'data' => []
        ]);
        return redirect()->route('throne.'.$this->default);
    }

    public function delete() {
        $id = $this->getRouteParameter('id');

        $lang = $this->model->find($id);
        Translates::where('locale', $lang['locale'])->delete();

        $this->model->find($id)->forceDelete();
        $this->deleteCache($lang);

        Logs::saveData([
            'lang' => 0,
            'type' => $this->default,
            'element_id' => $id,
            'action' => 3,
            'data' => $lang
        ]);

        session()->flash('success', trans('admin.alert.delete'));
        session()->flash('change_url', route('throne.'.$this->default, isset($this->boss) ? $this->boss[1] : []));
        return redirect()->route('throne.'.$this->default, isset($this->boss) ? $this->boss[1] : []);
    }

    public function getAllText($input){
        $translates = Translates::where('group', '!=', 'admin')->where('group', '!=', 'help');
        $translates = $this->check($input, $translates);
        $translates = $translates->where('locale', Languages::pluck('locale')->first())->groupBy('item')->orderBy('group','desc')->paginate(25);

        return $translates;
    }
    public function text(){
        Paginator::currentPageResolver(function() {
            return session('page_language_text');
        });

        $translates = $this->getAllText(session('log_input_language_text'));

        View::share('translates', $translates);
        return $this->renderView('text.index');
    }

    public function page() {
        session()->put('page_language_text', isset($_GET['page']) ? $_GET['page'] : 1);
        $translates = $this->getAllText(session('log_input_language_text'));

        View::share('translates', $translates);
        return $this->renderView('text.content');
    }

    public function api(){
        $e = request()->all();

        session()->put('page_language_text', isset($_GET['page']) ? $_GET['page'] : 1);
        $translates = $this->getAllText($e);

        $return = [];
        if(count($translates) == 0){
            $return['return'] = false;
            $return['msg'] = trans('admin.'.$this->default.'.alerts.notfound');
        }else{
            View::share('translates', $translates);

            $return['return'] = true;
            $return['content'] = $this->renderView('text.content', [], true);
        }

        session()->put('log_input_language_text',$e);

        return $return;
    }

    public function text_edit($id) {
        $data = Translates::find($id);
        if($data) {
            View::share('data', $data);

            if(request()->isMethod('post')) {
                $e = request()->all();

                foreach($e['items'] as $key => $item){
                    Translates::where('id', $key)->update(['text' => $item, 'locked' => 1]);
                }
                if(isset($e['new'])){
                    foreach($e['new'] as $locale => $item){
                        $model = new Translates();
                        $model->locale = $locale;
                        $model->namespace = '*';
                        $model->group = $data['group'];
                        $model->item = $data['item'];
                        $model->locked = 1;
                        $model->text = $item;
                        $model->save();
                    }
                }

                session()->flash('success', trans('admin.alert.save'));

                Logs::saveData([
                    'lang' => 0,
                    'type' => $data::$name,
                    'element_id' => $id,
                    'action' => 2,
                    'data' => $e
                ]);

                if($e['submit'] == 1){
                    return redirect()->route('throne.language_text.edit', $id);
                }else{
                    session()->flash('change_url', route('throne.language_text'));
                    return redirect()->route('throne.language_text');
                }
            }

            View::share('items', Translates::where('group', '!=', 'admin')->where('group', '!=', 'help')->where('item', $data['item'])->get());
            View::share('languages', $this->model->pluck('name','locale')->all());

            return $this->renderView('text.edit');
        }

        return redirect()->route('throne.language_text');
    }

    private function keyToString($array, $name, $group){
        foreach($array as $key => $item){
            if(is_array($item)){
                $this->keyToString($item, $name.$key.'.', $group);
            }else{
                $this->translations[$this->locale][$group][$name.$key] = $item;
            }
        }
    }

    public function sync(){
        $default = include_once resource_path('lang/hu/public.php');
        $this->locale = 'hu';
        $this->keyToString($default, 'public.', 'public');

        foreach(glob(base_path('resources/lang/*/public.php')) as $file){
            $file = str_replace('\\', '/', $file);
            $group = basename(str_replace('.php', '', $file));
            $locale = basename(str_replace($group.'.php', '', $file));

            $this->locale = $locale;
            $array = include $file;

            if($array){
                $this->keyToString($array, 'public.', $group);
                $this->translations[$locale][$group] = array_merge($this->translations['hu']['public'], $this->translations[$locale][$group]);
            }
        }

        foreach($this->translations as $locale => $items){
            foreach($items as $group => $item){
                $locked = Translates::where('locale', $locale)->where('group', 'public')->where('locked', 1)->pluck('id', 'item')->all();
                $data = Translates::where('locale', $locale)->where('group', 'public')->pluck('text', 'item')->all();

                if($data){
                    $diff = array_merge(array_diff($item, $data), array_diff_key($item, $data));
                    if($locked){
                        $diff = array_diff_key($diff, $locked);
                    }

                    Translates::where('locale', $locale)->where('group', 'public')->whereIn('item', array_keys(array_diff_assoc($data, $item)))->where('locked', 0)->delete();
                }else{
                    $diff = $item;
                }

                $array = [];

                foreach($diff as $key => $text){
                    $array[] = [
                        'locale' => $locale,
                        'namespace' => '*',
                        'group' => 'public',
                        'item' => $key,
                        'text' => $text,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }

                if($array){
                    $columns = array_keys($array[0]);
                    $values = array_chunk($array, 100);

                    foreach($values as $value){
                        $value_sql = rtrim(str_repeat('('.rtrim(str_repeat('?,', count($columns)), ',').'),', count($value)), ',');
                        $sql = "REPLACE INTO translator_translations (`".implode('`,`', $columns)."`) VALUES".$value_sql;

                        $bindings = [];
                        foreach($value as $items){
                            foreach($items as $item){
                                $bindings[] = $item;
                            }
                        }

                        DB::statement($sql, $bindings);
                    }
                }
            }
        }
    }
}
