<?php namespace App\Http\Controllers\Throne;

use App\Exports\FormUsersExport;
use App\Models\Domains;
use App\Models\Forms;
use App\Models\FormUsers;
use App\Models\Languages;
use App\Models\Logs;
use App\Models\Pets;
use App\Models\Translates;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class FormUsersController extends Controller
{
    public function __construct(Forms $main_model, FormUsers $model){
        $this->main_model = $main_model::$name;
        $this->model = $model;
        $this->default = $model::$name;
        $this->boss = ['form', $this->getRouteParameter('form')];
        $this->set_stats = [
            'reg' => function($sql){
                return $sql->count();
            },
            'reg_now' => function($sql){
                return $sql->whereRaw('DATE(created_at) = "'.date('Y-m-d').'"')->count();
            }
        ];

        View::share('form', $this->boss[1]);
    }

    public function export() {
        $file = 'formusers-export-'.date('Y-m-d-H\h-i\m').'.xls';

        $form = Forms::find($this->boss[1]);
        $form['data'] = json_decode($form['data'], true);
        $form['json'] = $form['data']['json'];
        $form->getInputs($form['json'], ['html','aszf','button']);
        $form->hasFileInput();

        $form_users = $this->model->where('form', $form['id']);
        $form_users = $this->check(session('log_input_'.$this->default), $form_users);
        $form_users = $form_users->orderBy('id', 'desc')->get();

        $header = [trans('admin.'.$this->default.'.table.id')];
        $header[] = trans('admin.'.$this->default.'.table.page');
        $header = array_merge($header, array_keys($form->inputs));
        $header[] = trans('admin.'.$this->default.'.table.created_at');

        $datas = [];

        foreach($form_users as $item) {
            $data = json_decode($item['data'], true);

            $columns = ['#'.$item['id']];
            $columns[] = $item['page'];

            foreach($form->inputs as $key => $input){
                if(isset($data[$key])){
                    if(is_array($data[$key])){
                        $columns[] = implode(', ', $data[$key]);
                    }else{
                        if($input['type'] == 'map'){
                            $coordinate = json_decode($data[$key], true);
                            if(isset($coordinate['lat'], $coordinate['lng'])){
                                $columns[] = '=Hyperlink("https://www.google.hu/maps/place/'.$coordinate['lat'].','.$coordinate['lng'].'", "Google Map - '.$coordinate['lat'].','.$coordinate['lng'].'")';
                            }else{
                                $columns[] = '';
                            }
                        }else{
                            $columns[] = $data[$key].'';
                        }
                    }
                }else{
                    $columns[] = '';
                }
            }
            $columns[] = $item['created_at'].'';

            $datas[] = $columns;
        }

        Logs::saveData([
            'type' => $this->default,
            'element_id' => 0,
            'action' => 6,
            'data' => []
        ]);

        return (new FormUsersExport(collect($datas), $header))->download($file);
    }

    public function show($boss, $id){
        $user = $this->model->where('form', $boss)->find($id);

        if($user){
            $user['data'] = json_decode($user['data'], true);

            View::share('data', $user);
            return $this->renderView('show');
        }

        return redirect()->back();
    }
}
