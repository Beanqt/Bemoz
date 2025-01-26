<?php

function str_limit($string, $limit){
    return \Illuminate\Support\Str::limit($string, $limit);
}

function setting($name, $lang = false){
	return app('SettingsService')->get($name, $lang);
}

function slug($string){
	return \Illuminate\Support\Str::slug(str_replace(['Ü','ü','ö','Ö'], ['u','u','o','o'], $string));
}

function assetVersion($url){
	$version = filemtime(public_path($url));

	return asset($url.'?v='.$version);
}

function protect_email($email)
{
	$pieces = explode("@", $email);

	if(isset($pieces[0]) && isset($pieces[1])) {

		return '
			<script>
				var a = "<a href=\'mailto:";
				var b = "' . $pieces[0] . '";
				var c = "' . $pieces[1] . '";
				var d = "\'>";
				var e = "</a>";
				document.write(a+b+"@"+c+d+b+"@"+c+e);
			</script>
		';
	}

	return false;
}

function removeShortCode($content){
	preg_match_all("/\\[(.+)\\|(.+)\\]/siU",$content,$matches);

	$mit = [];
	$mre = [];
	foreach($matches[0] as $key=>$piece){
		$mit[] = $piece;
		$mre[] = '';
	}

	$content = str_replace($mit,$mre,$content);

	preg_match_all("/\\[(.+)\\|(.+)\\|(.+)\\]/siU",$content,$matches2);

	foreach($matches2[0] as $key=>$piece){
		$mit[] = $piece;
		$mre[] = '';
	}

	$content = str_replace($mit,$mre,$content);
	return $content;
}

function getLayoutContent($content){
	if(json_decode($content, true)){
		$content = json_decode($content, true);
		$html = '';

		foreach($content as $item){
			if(isset($item['content'])){
				$html .= $item['content'];
			}
		}

		return $html;
	}
	return $content;
}

function getFilterDate($time, $nextTime = false){
	$array = explode(' ',$time);

	if(count($array) > 1){
		$arrayTime = explode(':', $array[1]);

		if(isset($arrayTime[0])){
			$hour = $arrayTime[0];
		}else{
			$hour = '00';
		}
		if(isset($arrayTime[1])){
			$minute = $arrayTime[1];
		}else{
			$minute = '00';
		}
		if(isset($arrayTime[2])){
			$second = $arrayTime[2];
		}else{
			$second = '00';
		}

		$dateTime = date('Y-m-d H:i:s', strtotime($array[0] . ' ' . $hour . ':' . $minute . ':' . $second));

		if($nextTime){
			if($minute=='00' && !isset($arrayTime[1])){
				$dateTime = date('Y-m-d H:i:s', strtotime('+59 minutes 59 seconds', strtotime($dateTime)));
			}elseif($second=='00' && !isset($arrayTime[2])){
				$dateTime = date('Y-m-d H:i:s', strtotime('+59 seconds', strtotime($dateTime)));
			}
		}

		$date = date('Y-m-d H:i:s', strtotime($dateTime));
	}else{
		$arrayDate = explode('-', $time);

		if(isset($arrayDate[0])){
			$year = $arrayDate[0];
		}else{
			$year = '1970';
		}
		if(isset($arrayDate[1])){
			$month = $arrayDate[1];
		}else{
			$month = '01';
		}
		if(isset($arrayDate[2])){
			$day = $arrayDate[2];
		}else{
			$day = '01';
		}

		$date = date('Y-m-d H:i:s', strtotime($year . '-' . $month . '-' . $day));

		if($nextTime){
			$date = date('Y-m-d H:i:s', strtotime((!isset($arrayDate[2]) ? '+1 month 23 hours 59 minutes 59 seconds - 1 day' : '+23 hours 59 minutes 59 seconds'), strtotime($time)));
		}
	}

	return $date;
}

function getIcon($item, $with_image = false){
	$ext = explode(".",$item);
	$ext = end($ext);

	switch($ext){
		case 'pdf':
			$icon = '<i class="fa far fa-file-pdf"></i>';
			break;
		case 'xls':
			$icon = '<i class="fa far fa-file-excel"></i>';
			break;
		case 'xlsx':
			$icon = '<i class="fa far fa-file-excel"></i>';
			break;
		case 'doc':
			$icon = '<i class="fa far fa-file-word"></i>';
			break;
		case 'docx':
			$icon = '<i class="fa far fa-file-word"></i>';
			break;
		case 'jpg':
			$icon = '<i class="fa far fa-file-image"></i>';
			break;
		case 'jpeg':
			$icon = '<i class="fa far fa-file-image"></i>';
			break;
		case 'png':
			$icon = '<i class="fa far fa-file-image"></i>';
			break;
		default:
			$icon = '<i class="fa far fa-file"></i>';
			break;
	}

	if($with_image && in_array($ext, ['jpeg','jpg','png','gif'])){
		$icon = '<img class="img-responsive" src="'.$item.'">';
	}

	return $icon;
}

function getSeoData($data, $image = null){
	if(isset($data->seo) && $data->seo){
		$meta['title'] = !empty($data->seo['title']) ? $data->seo['title'] : $data['title'];
		$meta['keywords'] = !empty($data->seo['keywords']) ? $data->seo['keywords'] : $data['title'];
		$meta['description'] = !empty($data->seo['desc']) ? $data->seo['desc'] : (isset($data['short']) ? str_limit($data['short'], 160) : (isset($data['content']) ? str_limit(strip_tags(getLayoutContent($data->getOriginal('content'))), 160) : ''));
		$meta['addthis'] = $data->seo['addthis'];
		$meta['nofollow'] = $data->seo['nofollow'];
		$meta['image'] = !empty($data->seo['image']) ? asset('uploads/seo/small-'.$data->seo['image']) : '';

		return $meta;
	}
	$meta['title'] = $data['title'];
	$meta['keywords'] = isset($data['keywords']) ? $data['keywords'] : $data['title'];
	$meta['description'] = isset($data['short']) ? str_limit($data['short'], 160) : (isset($data['content']) ? str_limit(strip_tags(getLayoutContent($data->getOriginal('content'))), 160) : '');
	$meta['addthis'] = isset($data['addthis']) ? $data['addthis'] : 0;
	$meta['nofollow'] = isset($data['nofollow']) ? $data['nofollow'] : 0;
	$meta['image'] = !is_null($image) ? asset('uploads/'.$image.$data['image']) : '';

	return $meta;
}

function getLangString($json, $first = false){
	$string = '';
	$array = json_decode($json, true);

	if($first && is_array($array)){
		$string = current($array);
	}elseif(is_array($array)){
		if(array_key_exists(App::getLocale(), $array)){
			$string = $array[App::getLocale()];
		}else{
			$string = null;
		}
	}

	return $string;
}

function getPercent($value, $all, $floor = false){
	if($value == 0){
		return 0;
	}

	if($floor){
		return floor($value/$all*100);
	}
	return $value/$all*100;
}

function replaceNull($item){
	if(is_array($item)){
		foreach($item as $key => $element){
			if(is_null($element)){
				$item[$key] = '';
			}
		}
	}else{
		if(is_null($item)){
			$item = '';
		}
	}

	return $item;
}

function can($permission = null, $guard = 'admin'){
	return auth()->guard($guard)->user()->havePermission($permission);
}

function activeMenu($name){
	if(is_array($name)){
		foreach($name as $item){
			if(strpos(Route::currentRouteName(), '.'.$item)){
				return true;
			}
		}
	}elseif(strpos(Route::currentRouteName(), '.'.$name)){
		return true;
	}

	return false;
}

function fileExtension($file){
	$ext = explode(".",$file);
	$ext = end($ext);

	return $ext;
}

function deleteDir($path){
	if(file_exists($path)) {
		if (substr($path, strlen($path) - 1, 1) != '/') {
			$path .= '/';
		}
		$files = glob($path . '*', GLOB_MARK);

		foreach ($files as $file) {
			if (is_dir($file)) {
				deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($path);
	}
}

function replaceDate($format, $date) {
	$month = date('M', strtotime($date));
	$day = date('D', strtotime($date));
	$date = date($format, strtotime($date));

	return str_replace([$month, $day], [trans('public.month.'.strtolower($month)),trans('public.day.'.strtolower($day))], $date);
}

function checkOpening($opening) {
	foreach($opening as $item)
	{
		if( !empty($item['simple']) )
		{
			return true;
		}
	}

	return false;
}

function checkHttp($url){
	if(substr($url, 0, 3) == 'www'){
		return 'http://'.$url;
	}

	return $url;
}

function getRoute($data, $other = null){
	$name = isset($data['permission_name']) ? $data['permission_name'] : '';
	$controller = isset($data['controller']) ? $data['controller'] : '';
	$data['actions'] = isset($data['actions']) ? $data['actions'] : [];

	$permissions = [
		'text' => 'edit',
		'featured' => 'edit',
		'status' => 'edit',
		'show' => 'read',
		'preview' => 'read',
		'delete' => 'delete',
	];

	if($controller){
		Route::group(['prefix' => isset($data['prefix']) ? $data['prefix'] : '', 'permission_name' => $name], function() use($name, $data, $controller, $other, $permissions) {
			Route::get('/', ['as' => 'throne.'.$name, 'uses' => $controller.'Controller@index'])->middleware('permission:read');

			if(in_array('new', $data['actions'])) {
				Route::match(['post', 'get'], '/new', ['as' => 'throne.'.$name.'.new', 'uses' => $controller.'Controller@create'])->middleware('permission:new');
			}
			if(in_array('edit', $data['actions'])) {
				Route::match(['post', 'get'], '/edit/{id}'.(in_array('archive', $data['actions']) ? '/{archived?}' : ''), ['as' => 'throne.'.$name.'.edit', 'uses' => $controller.'Controller@edit'])->middleware('permission:edit');
			}

			foreach(['text','featured','status','show','preview','delete'] as $item){
				if(in_array($item, $data['actions'])) {
					Route::match(['post', 'get'], '/'.$item.'/{id}', ['as' => 'throne.'.$name.'.'.$item, 'uses' => $controller.'Controller@'.$item])->middleware('permission:'.$permissions[$item]);
				}
			}

			if(in_array('sort', $data['actions'])) {
				Route::match(['post', 'get'], '/sort', ['as' => 'throne.'.$name.'.sort', 'uses' => $controller.'Controller@sort'])->middleware('permission:edit');
			}
			if(in_array('export', $data['actions'])) {
				Route::match(['post', 'get'], '/export', ['as' => 'throne.'.$name.'.export', 'uses' => $controller.'Controller@export'])->middleware('permission:export');
			}
			if(in_array('upload', $data['actions'])) {
				Route::post('/fileUpload', ['as' => 'throne.'.$name.'.fileUpload', 'uses' => $controller.'Controller@fileUpload'])->middleware('permission:edit');
			}

			if(in_array('trash', $data['actions'])) {
				Route::group(['prefix' => '/trash'], function() use($name, $controller, $data) {
					Route::get('/', ['as' => 'throne.'.$name.'.trash', 'uses' => $controller.'Controller@trash'])->middleware('permission:trash');
					Route::get('/restore/{id}', ['as' => 'throne.'.$name.'.trash.restore', 'uses' => $controller.'Controller@trashRestore'])->middleware('permission:trash');
					Route::get('/delete/{id}', ['as' => 'throne.'.$name.'.trash.delete', 'uses' => $controller.'Controller@trashDelete'])->middleware('permission:trash');
				});
			}

			if(in_array('api', $data['actions'])){
				Route::group(['prefix' => 'api'], function() use($name, $controller, $data) {
					Route::post('/', ['as' => 'throne.'.$name.'.api', 'uses' => $controller.'Controller@api']);
					Route::get('/', ['as' => 'throne.'.$name.'.api', 'uses' => $controller.'Controller@page']);
				});
			}

			if(is_callable($other)){
				call_user_func($other);
			}
		});
	}
}

function getJsonContent($e){
	return $e['layout'];
}
