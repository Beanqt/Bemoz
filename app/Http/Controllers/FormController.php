<?php namespace App\Http\Controllers;

use App\Models\Cron;
use App\Models\FormContent;
use App\Models\Forms;
use App\Models\FormUsers;
use Illuminate\Support\Facades\View;

class FormController extends Controller {

	public function index($id){
		$e = request()->all();

		if(auth()->guard('admin')->user()){
			$form = Forms::lang()->find($id);
		}else{
			$form = Forms::lang()->public()->find($id);
		}

		if($form){
			$form['data'] = json_decode($form['data'], true);
			$form['json'] = $form['data']['json'];

			if(FormUsers::isValid($form)){
				$model = FormUsers::saveData($form);

				$bossEmail = FormContent::where('form', $id)->where('type', 1)->first();
				$userEmail = FormContent::where('form', $id)->where('type', 2)->first();

				if($bossEmail){
					$data = json_decode($model->data, true);
					$bossEmail['content'] = $this->replaceFormShortcode($bossEmail['content'], FormUsers::$allowed_input, $form);

					$cron['template'] = 'emails.default';
					$cron['send'] = $bossEmail['emails'];
					$cron['subject'] = $bossEmail['subject'];
					$cron['data'] = ['content' => $bossEmail['content']];

					if(isset($data['files'])){
						foreach($data['files'] as $key => $file){
							if(file_exists(storage_path('form_users/'.$model->id.'/'.$file))){
								$size = filesize(storage_path('form_users/'.$model->id.'/'.$file))/1024/1024;

								if($size < 25){
									$data['files'][$key] = storage_path('form_users/'.$model->id.'/'.$file);
								}
							}
						}
						$cron['attachments'] = $data['files'];
					}

					Cron::saveData(1, $cron);
				}

				if($userEmail && FormUsers::$email) {
					$userEmail['content'] = $this->replaceFormShortcode($userEmail['content'], FormUsers::$allowed_input, $form);

					$cron['template'] = 'emails.default';
					$cron['send'] = FormUsers::$email;
					$cron['subject'] = $userEmail['subject'];
					$cron['data'] = ['content' => $userEmail['content']];

					Cron::saveData(1, $cron);
				}

				session()->put('successForm', $model->id);
				return redirect()->route('form.success', $id);
			}
		}
		return redirect()->to(url()->previous().'#form-'.$id)->withErrors(FormUsers::$validator)->withInput($e);
	}

	public function success($id){
		if(session()->get('successForm')){
			$user = FormUsers::find(session()->get('successForm'));

			if($user){
				$user['data'] = json_decode($user['data'], true);
				$form = Forms::find($user['form']);
				$form['data'] = json_decode($form['data'], true);
				$form['json'] = $form['data']['json'];

				$content = FormContent::where('form',$form['id'])->where('type', 3)->first();

				session()->forget('successForm');

				if($content){
					$data['content'] = $this->replaceFormShortcode($content['content'], $user['data'], $form);
					$data['title'] = '';

					View::share('page', $data);
					return View::make('embed.form.success');
				}else{
					session()->flash('form_'.$id.'_success', trans('public.alerts.success'));
					return redirect()->back();
				}
			}
		}
		abort('404');
		die();
	}

	public function replaceFormShortcode($content, $input, $form){
		$mit = [];
		$mir = [];

		$form->getInputs($form['json']);

		foreach($form->inputs as $key => $input_item){
			$mit[] = '['.$key.']';

			if(array_key_exists($key, $input)){
				$item = $input[$key];

				if(is_array($item)){
					$html = '<ul>';
					foreach($item as $element){
						$html .= '<li>'.$form->replaceValue($element, $form->inputs[$key]).'</li>';
					}
					$html .= '</ul>';

					$mir[] = $html;
				}else{
					if($input_item['type'] == 'map'){
						$coordinate = json_decode($item, true);
						if(isset($coordinate['lat'], $coordinate['lng'])){
							$mir[] = '<a href="https://www.google.hu/maps/place/'.$coordinate['lat'].','.$coordinate['lng'].'" target="_blank">Google Map ('.$coordinate['lat'].','.$coordinate['lng'].')</a>';
						}else{
							$mir[] = '';
						}
					}else{
						$mir[] = $form->replaceValue($item, $form->inputs[$key]);
					}
				}
			}else{
				$mir[] = '';
			}
		}

		return str_replace($mit, $mir, $content);
	}
}
