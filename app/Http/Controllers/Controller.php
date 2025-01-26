<?php namespace App\Http\Controllers;

use App\Models\Cache;
use App\Models\DocumentCategory;
use App\Models\DocumentItem;
use App\Models\Forms;
use App\Models\Gallery;
use App\Models\Images;
use App\Models\Video;
use App\Models\VideoGallery;
use App\Models\Widget;
use Illuminate\Support\Facades\View;

abstract class Controller {
    public $mit = [];
    public $mre = [];
    public $data = [];
    public $lang;
    public $html = '';
    public $styles = '';

    public $videobreadcrumb = [];
    public $documentbreadcrumb = [];
    public $gallerybreadcrumb = [];

    public function parseContent($layout, $force_template = null){
        $this->lang = app('LanguageService')->getLangId();

        if(json_decode($layout, true)){
            $layout = json_decode($layout, true);
        }

        $template = 2;

        if($layout && is_array($layout) && isset($layout[count($layout)-1]['template'])){
            $template = $layout[count($layout)-1]['template'];
            unset($layout[count($layout)-1]['template']);
        }

        if(!is_null($force_template)){
            $template = $force_template;
        }

        if(is_array($layout)){
            foreach($layout as $item){
                if(isset($item['grids'])){
                    $this->html .= $this->loadGrids($item, $template);
                }elseif(isset($item['type'])){
                    $this->html .= $this->loadModules($item, $template);
                }
            }
        }elseif($layout != '[]'){
            $this->html .= $this->parsePage($this->parseShortCode($layout), $template);
        }

        if($this->styles){
            View::share('styles', $this->styles);
        }
        View::share('template', $template);
        return $this->html;
    }

    public function loadModules($item, $template = 2){
        if($item['type'] == 'content' && isset($item['content'])){
            $item['content'] = $this->parseShortCode($item['content']);
            return $this->parsePage($item['content'], $template);
        }elseif($item['type'] == 'forms' && isset($item['id'])){
            return $this->parseForms($item['id'], $template);
        }elseif($item['type'] == 'widget' && isset($item['id'])) {
            return $this->parseWidget($item['id'], $template);
        }elseif($item['type'] == 'gallery' && isset($item['id'],$item['mode'])) {
            return $this->parseGallery($item['id'],$item['mode'], $template);
        }elseif($item['type'] == 'images' && isset($item['id'])) {
            return $this->parseImage($item['id'], $template);
        }elseif($item['type'] == 'video_category' && isset($item['id'])) {
            return $this->parseVideoCategory($item['id'], $template);
        }elseif($item['type'] == 'video' && isset($item['id'])) {
            return $this->parseVideo($item['id'], $template);
        }elseif($item['type'] == 'document_category' && isset($item['id'])) {
            return $this->parseDocumentCategory($item['id'], $template);
        }elseif($item['type'] == 'document' && isset($item['id'])) {
            return $this->parseDocument($item['id'], $template);
        }

        return '';
    }

    public function loadGrids($grids, $template){
        $id = str_replace('.', '', microtime(true));
        $images = ['main' => []];

        if(isset($grids['styles']) && is_array($grids['styles'])){
            $this->styles .= '.grid-main-'.$id.' {';
            foreach($grids['styles'] as $key => $style){
                if(strpos($key, 'option-') === false){
                    $this->styles .= $key.':'.$style.';';
                }
            }
            $this->styles .= '}';
            if(in_array('justify-content', array_keys($grids['styles']))){
                $this->styles .= '.grid-main-'.$id.' > .grid-row { display: flex; justify-content: center;}';
            }

            if(isset($grids['styles']['option-background-id'],$grids['styles']['option-background-type'])){
                if($grids['styles']['option-background-type'] == 'gallery'){
                    $images['main'] = \App\Models\Gallery::where('active',1)->with('galleryimage')->where('id', $grids['styles']['option-background-id'])->pluck('galleryimage')->all();
                }else{
                    $images['main'] = \App\Models\Images::where('active',1)->where('id', $grids['styles']['option-background-id'])->get();
                }

                if(count($images['main']) == 1 && isset($grids['styles']['option-animation'])){
                    $this->styles .= '
                        .grid-main-'.$id.' > .grid-background {
                            position: absolute;
                            top: 0;
                            bottom: 0;
                            left: 0;
                            width: 120%;
                            -webkit-animation: '.$grids['styles']['option-animation'].' 9s linear infinite;
                            animation: '.$grids['styles']['option-animation'].' 9s linear infinite;
                            background-image: url(/uploads/gallery/'.$images['main'][0]['category'].'/small-'.$images['main'][0]['image'].');
                            background-repeat: no-repeat;
                            background-size: cover;
                        }
                    ';
                }elseif(count($images['main']) == 1){
                    $this->styles .= '
                        .grid-main-'.$id.' {
                            background-image: url(/uploads/gallery/'.$images['main'][0]['category'].'/small-'.$images['main'][0]['image'].');
                            background-repeat: no-repeat;
                            background-size: cover;
                        }
                    ';
                }
            }
        }

        foreach($grids['grids'] as $key => $grid){
            if(isset($grid['styles']) && is_array($grid['styles'])){
                $this->styles .= '.grid-main-'.$id.' .grid-item-'.$key.' {overflow: hidden;';
                foreach($grid['styles'] as $style_key => $style){
                    if(strpos($style_key, 'option-') === false){
                        $this->styles .= $style_key.':'.$style.';';
                    }
                }
                $this->styles .= '}';

                if(isset($grid['styles']['option-background-id'],$grid['styles']['option-background-type'])){
                    if($grid['styles']['option-background-type'] == 'gallery'){
                        $images[$key] = \App\Models\Gallery::where('active',1)->with('galleryimage')->where('id', $grid['styles']['option-background-id'])->pluck('galleryimage')->all();
                    }else{
                        $images[$key] = \App\Models\Images::where('active',1)->where('id', $grid['styles']['option-background-id'])->get();
                    }

                    if(count($images[$key]) == 1 && isset($grid['styles']['option-animation'])){
                        $this->styles .= '
                            .grid-main-'.$id.' .grid-item-'.$key.' > .grid-background {
                                position: absolute;
                                top: 0;
                                bottom: 0;
                                left: 0;
                                width: 120%;
                                -webkit-animation: '.$grid['styles']['option-animation'].' 9s linear infinite;
                                animation: '.$grid['styles']['option-animation'].' 9s linear infinite;
                                background-image: url(/uploads/gallery/'.$images[$key][0]['category'].'/small-'.$images[$key][0]['image'].');
                                background-repeat: no-repeat;
                                background-size: cover;
                            }
                            @media screen and (max-width: 1199px) {
                                .grid-main-'.$id.' .grid-item-'.$key.' > .grid-background {
                                    width: auto;
                                    position: static;
                                    margin: 0 -15px;
                                    animation: none;
                                    height: 300px;
                                }
                            }
                        ';
                        if(($key-1)%2 == 0 && $key != 0){
                            $this->styles .= '@media screen and (max-width: 1199px) {
                                .grid-main-'.$id.' .grid-item-'.($key-1).' {margin-top: 300px;}
                                .grid-main-'.$id.' .grid-item-'.$key.' {position: absolute;top: 0;height: 300px;}
                                .grid-main-'.$id.' .grid-row {position: relative;}
                            }';
                        }
                    }elseif(count($images[$key]) == 1){
                        $media_style = '@media screen and (max-width: 1199px) {';
                        if($key == 1){
                            $media_style .= '.grid-main-'.$id.' .grid-item-0 {margin-top: 300px;}';
                            $media_style .= '.grid-main-'.$id.' .grid-item-1 {position: absolute;top: 0;height: 300px;}';
                            $media_style .= '.grid-main-'.$id.' .grid-row {position: relative;}';
                        }else{
                            $media_style .= '.grid-main-'.$id.' .grid-item-'.$key.' {height: 300px;}';
                        }
                        $media_style .= '}';

                        $this->styles .= '
                        .grid-main-'.$id.' .grid-item-'.$key.' {
                            background-image: url(/uploads/gallery/'.$images[$key][0]['category'].'/small-'.$images[$key][0]['image'].');
                            background-repeat: no-repeat;
                            background-size: cover;
                            background-position: center center;
                        }
                    ';
                        $this->styles .= $media_style;
                    }
                }

                $this->styles .= '
                    @media screen and (max-width: 1199px) {
                        .grid-main-'.$id.' .grid-item-'.$key.' {
                            width: 100%;
                            min-height: initial;
                        }
                    }
                ';
            }
        }

        $this->styles .= '
            @media screen and (max-width: 1199px) {
                .grid-main-'.$id.' .grid-row {
                    display: block;
                    margin-bottom: 20px;
                }
            }
        ';

        return view('embed.grids')->with('grids', $grids)->with('images', $images)->with('service', $this)->with('id', $id)->with('layout', $template)->render();
    }

    public function parseShortCode($content){
        $content = str_replace('<div style="page-break-after:always"><span style="display:none">&nbsp;</span></div>', '[More|More]', $content);
        $more = false;
        preg_match_all("/\\[(.+)\\|(.+)\\]/siU",$content,$matches);

        foreach($matches[0] as $key=>$code){
            $item['content'] = str_replace('<p>'.$code.'</p>', $code, $content);
            switch($matches[1][$key]){
                case 'EmailProtect':
                    $this->EmailProtect($matches[2][$key],$code);
                    break;
                case 'More':
                    $more = true;
                    $this->More($matches[2][$key],$code);
                    break;
            }
        }

        $content = str_replace($this->mit,$this->mre,$content);

        preg_match_all("/\\[(.+)\\|(.+)\\|(.+)\\]/siU",$content,$matches2);

        foreach($matches2[0] as $key=>$code){
            $item['content'] = str_replace('<p>'.$code.'</p>', $code, $content);
            switch($matches2[1][$key]){
                case 'Button':
                    $this->parseButton($matches2[2][$key],$matches2[3][$key],$code);
                    break;
            }
        }

        $content = str_replace($this->mit,$this->mre,$content);

        if($more){
            $content .= '</div><span class="btn btn-more btn-more-content">'.trans('public.btn.more').'</span></div>';
        }

        return $content;
    }

    public function parsePage($content, $template){
        return view('embed.content')->with('content', $content)->with('layout', $template)->render();
    }

    public function EmailProtect($email,$code)
    {
        $array = explode('{+}',$email);
        $email = isset($array[0]) ? $array[0] : '';
        $text = isset($array[1]) ? $array[1] : '';

        $explode_email = explode('@',$email);
        $explode_text = explode('@',$text);

        $this->mit[] = $code;

        if(count($explode_text)>1) {
            $this->mre[] = '<script>
				var a = "<a href=\'mailto:";
				var b = "' . $explode_email[0] . '";
				var c = "' . $explode_email[1] . '";
				var d = "\'>";
				var e = "</a>";
				var f = "' . $explode_text[0] . '";
				var g = "' . $explode_text[1] . '";
				document.write(a+b+"@"+c+d+f+"@"+g+e);
			</script>';
        }else{
            $this->mre[] = '<script>
				var a = "<a href=\'mailto:";
				var b = "' . $explode_email[0] . '";
				var c = "' . $explode_email[1] . '";
				var d = "\'>";
				var e = "</a>";
				document.write(a+b+"@"+c+d+"'.$text.'"+e);
			</script>';
        }
    }

    public function More($id,$code){
        $this->mit[] = $code;
        $this->mre[] = '<div class="page-break"><div class="page-break-text">';
    }

    public function parseButton($text,$open,$code)
    {
        $array = explode('{+}',$text);
        $link = isset($array[0]) ? $array[0] : '';
        $text = isset($array[1]) ? $array[1] : '';
        $ga = isset($array[2]) ? $array[2] : '';

        $this->mit[] = $code;
        $this->mre[] = view('embed.button')->with('link', $link)->with('text', $text)->with('open', $open)->with('ga', $ga)->render();
    }

    public function parseVideoCategory($id, $template){
        $this->videobreadcrumb = [];

        $video = Cache::remember('video_category.'.$id, 60, function() use($id){
            return VideoGallery::where('active',1)->find($id);
        });
        $have = $this->getVideoActive($video['boss']);

        if($video && $have){
            $folders = Cache::remember('video_category.folder.'.$id, 60, function() use($id){
                return VideoGallery::where('active',1)->where('boss',$id)->orderBy('order','asc')->get()->toArray();
            });
            $files = Cache::remember('video_items.'.$id, 60, function() use($id){
                return Video::where('category',$id)->where('active',1)->orderBy('order','asc')->get()->toArray();
            });

            $this->getVideoIds($video['id'], $id);
            ksort($this->videobreadcrumb);

            return view('embed.videocategory')->with('start', $id)->with('category', $video)->with('folders', $folders)->with('files', $files)->with('breadcrumb', $this->videobreadcrumb)->with('layout', $template)->render();
        }

        return '';
    }

    public function getVideoIds($id, $start = null) {
        $sub = VideoGallery::where('active',1)->find($id);

        if($sub) {
            $this->videobreadcrumb[$sub['order']]['active'] = true;
            $this->videobreadcrumb[$sub['order']]['title'] = $sub['title'];
            $this->videobreadcrumb[$sub['order']]['fold'] = $sub['id'];
            if(!empty($sub['boss']) && $start!=$sub['id']){
                $this->getVideoIds($sub['boss'], $start);
            }
        }
    }

    public function getVideoActive($id) {
        $sub = VideoGallery::find($id);
        if($id == 0){
            return true;
        }
        if($sub){
            if($sub['active'] == 1){
                if(!is_null($sub['boss']) && !empty($sub['boss'])) {
                    return $this->getVideoActive($sub['boss']);
                }else{
                    return true;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function parseVideo($id, $template){
        $video = Cache::remember('video.'.$id, 60, function() use($id){
            return Video::where('active',1)->with('videocategory')->find($id);
        });

        if($video){
            return view('embed.video')->with('video', $video)->with('layout', $template)->render();
        }

        return '';
    }

    public function parseDocumentCategory($id, $template){
        $this->documentbreadcrumb = [];

        $document = Cache::remember('document_category.'.$id, 60, function() use($id){
            return DocumentCategory::where('active',1)->find($id);
        });
        $have = $this->getDocumentActive($document['boss']);

        if($document && $have){
            $folders = Cache::remember('document_category.folder.'.$id, 60, function() use($id){
                return DocumentCategory::where('active',1)->where('boss',$id)->orderBy('order','asc')->get();
            });
            $files = Cache::remember('document_items.'.$id, 60, function() use($id){
                return DocumentItem::where('category',$id)->where('active',1)->orderBy('order','asc')->get()->toArray();
            });

            $this->getDocumentIds($document['id'], $id);
            ksort($this->documentbreadcrumb);

            return view('embed.documentcategory')->with('start', $id)->with('category', $document)->with('folders', $folders)->with('files', $files)->with('breadcrumb', $this->documentbreadcrumb)->with('layout', $template)->render();
        }

        return '';
    }

    public function getDocumentIds($id, $start = null) {
        $sub = DocumentCategory::where('active',1)->find($id);

        if($sub) {
            $this->documentbreadcrumb[] = [
                'active' => true,
                'title' => $sub['title'],
                'fold' => $sub['id'],
            ];

            if(!empty($sub['boss']) && $start!=$sub['id']){
                $this->getDocumentIds($sub['boss'], $start);
            }
        }
    }

    public function getDocumentActive($id) {
        $sub = DocumentCategory::find($id);
        if($id == 0){
            return true;
        }
        if($sub){
            if($sub['active'] == 1){
                if(!is_null($sub['boss']) && !empty($sub['boss'])) {
                    return $this->getDocumentActive($sub['boss']);
                }else{
                    return true;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function parseDocument($id, $template){
        $document = Cache::remember('documents.'.$id, 60, function() use($id){
            return DocumentItem::where('active',1)->find($id);
        });

        if($document){
            $document['icon'] = getIcon($document['file']);
            return view('embed.document')->with('document', $document)->with('layout', $template)->render();
        }

        return '';
    }

    public function parseGallery($id,$mod,$template){
        $this->gallerybreadcrumb = [];
        $gallery = Cache::remember('gallery.'.$id, 60, function() use($id){
            return Gallery::where('active',1)->find($id);
        });

        if($gallery){
            $images = Cache::remember('gallery_images.'.$id, 60, function() use($id){
                return Images::where('category',$id)->where('active',1)->orderBy('order','asc')->get()->toArray();
            });

            if($mod == 'simple'){
                $have = $this->getGalleryActive($gallery['boss']);

                if($have){
                    $folders = Cache::remember('gallery.folder.'.$id, 60, function() use($id){
                        return Gallery::where('active',1)->where('boss',$id)->with('first_image')->orderBy('order','asc')->get()->toArray();
                    });
                    $this->getGalleryIds($gallery['id'], $id);
                    ksort($this->gallerybreadcrumb);

                    return view('embed.gallery')->with('start', $id)->with('gallery', $gallery)->with('folders', $folders)->with('images', $images)->with('breadcrumb', $this->gallerybreadcrumb)->with('layout', $template)->render();
                }
            }elseif($mod == 'box'){
                return view('embed.gallery.box')->with('id', $id)->with('images', $images)->with('layout', $template)->render();
            }else{
                return view('embed.gallery.list')->with('id', $id)->with('images', $images)->with('layout', $template)->render();
            }
        }

        return '';
    }
    public function getGalleryIds($id, $start = null) {
        $sub = Gallery::where('active',1)->find($id);

        if($sub) {
            $this->gallerybreadcrumb[] = [
                'active' => true,
                'title' => $sub['title'],
                'fold' => $sub['id'],
            ];

            if(!empty($sub['boss']) && $start!=$sub['id']){
                $this->getGalleryIds($sub['boss'], $start);
            }
        }
    }

    public function getGalleryActive($id) {
        $sub = Gallery::find($id);
        if($id == 0){
            return true;
        }
        if($sub){
            if($sub['active'] == 1){
                if(!is_null($sub['boss']) && !empty($sub['boss'])) {
                    return $this->getGalleryActive($sub['boss']);
                }else{
                    return true;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function parseImage($id, $template){
        $image = Cache::remember('images.'.$id, 60, function() use($id){
            return Images::where('active',1)->find($id);
        });

        if($image){
            return view('embed.image')->with('image', $image)->with('layout', $template)->render();
        }

        return '';
    }

    public function parseWidget($id, $template){
        $widget = Widget::where('id', $id)->where('active', 1)->first();

        if($widget){
            $widget = $widget->toArray();
            $array = json_decode($widget['data'], true);
            $widget['data'] = isset($array['data']) ? $array['data'] : [];
            $widget['option'] = isset($array['option']) ? $array['option'] : [];
            $widget['style'] = isset($array['style']) ? $array['style'] : [];

            if(is_array($widget['style']) && count($widget['style'])){
                $this->styles .= '.widgetBox-'.$id.'{';
                foreach($widget['style'] as $key => $item){
                    if(in_array($key, ['template','image_crop','parallax'])){
                        continue;
                    }elseif($key == 'image'){
                        $this->styles .= 'background: url(/uploads/widget/'.$widget['type'].'/small-'.$item.') no-repeat center center'.(isset($widget['style']['parallax']) ? ' fixed' : '').';';
                        $this->styles .= 'background-size: cover;';
                    }elseif($item){
                        $this->styles .= $key.':'.$item.';';
                    }
                }
                $this->styles .= '}';
            }

            return view('embed.widget.'.$widget['type'])->with('id', $id)->with('widget', $widget)->with('layout', $template)->render();
        }

        return '';
    }

    public function parseForms($id, $template){
        if(auth()->guard('admin')->user()){
            $form = Forms::where('id', $id)->lang()->first();
        }else{
            $form = Forms::where('id', $id)->lang()->public()->first();
        }

        if($form){
            $form['data'] = json_decode($form['data'], true);
            $form['json'] = $form['data']['json'];
            $form->getInputs($form['json']);
            $form['file'] = $form->hasFileInput();

            $form = $form->toArray();

            return view('embed.form.forms')->with('id', $id)->with('form', $form)->with('layout', $template)->render();
        }

        return '';
    }
}
