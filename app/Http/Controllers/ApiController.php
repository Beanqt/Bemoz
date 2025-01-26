<?php namespace App\Http\Controllers;

use App\Models\Cache;
use App\Models\DocumentCategory;
use App\Models\DocumentItem;
use App\Models\Gallery;
use App\Models\Images;
use App\Models\Languages;
use App\Models\Video;
use App\Models\VideoGallery;
use Illuminate\Support\Facades\View;

class ApiController extends Controller {
	public $lang;

	public function __construct(){
		$lang = Languages::where('locale', app()->getLocale())->first();

		$this->lang = $lang['id'];
	}

	public function gallery($id = null){
		$gallery = Gallery::where('active',1)->find($id);
		$return = [];
		$this->gallerybreadcrumb = [];

		$return['return'] = false;
		$return['content'] = trans('public.ajax.nogallery');

		$have = $this->getGalleryActive($gallery['boss']);

		if($gallery && $have){
			$return['return'] = true;
			$folders = Cache::remember('gallery.folder.'.$id, 60, function() use($id){
				return Gallery::where('active',1)->where('boss',$id)->with('first_image')->orderBy('order','asc')->get()->toArray();
			});
			$images = Cache::remember('gallery_images.'.$id, 60, function() use($id){
				return Images::where('category',$id)->where('active',1)->orderBy('order','asc')->get()->toArray();
			});
			$this->getGalleryIds($gallery['id'], request()->get('start'));

			krsort($this->gallerybreadcrumb);

			$return['breadcrumb'] = '';

			foreach($this->gallerybreadcrumb as $bread){
				$return['breadcrumb'] .= '<li class="folder" data-id="'.$bread['fold'].'" data-type="gallery">'.$bread['title'].'</li>';
			}
			if(empty($return['breadcrumb'])){
				$return['breadcrumb'] = '<li>'.trans('public.embed.gallery.title').'</li>';
			}

			$return['content'] = View::make('embed.api.gallery', ['folders' => $folders, 'images' => $images])->render();
		}

		return $return;
	}

	public function document($id = null){
		$document = DocumentCategory::where('active',1)->find($id);
		$return = [];
		$this->documentbreadcrumb = [];

		$return['return'] = false;
		$return['content'] = trans('public.ajax.nodocument');

		$have = $this->getDocumentActive($document['boss']);

		if($document && $have){
			$return['return'] = true;
			$folders = Cache::remember('document_category.folder.'.$id, 60, function() use($id){
				return DocumentCategory::where('active',1)->where('boss',$id)->orderBy('order','asc')->get();
			});
			$files = Cache::remember('document_items.'.$id, 60, function() use($id){
				return DocumentItem::where('category',$id)->where('active',1)->orderBy('order','asc')->get()->toArray();
			});

			$this->getDocumentIds($document['id'], request()->get('start'));

			krsort($this->documentbreadcrumb);

			$return['breadcrumb'] = '';

			foreach($this->documentbreadcrumb as $bread){
				$return['breadcrumb'] .= '<li class="folder" data-id="'.$bread['fold'].'" data-type="document">'.$bread['title'].'</li>';
			}
			if(empty($return['breadcrumb'])){
				$return['breadcrumb'] = '<li>'.trans('public.embed.documentcategory.title').'</li>';
			}

			$return['content'] = View::make('embed.api.documentcategory', ['folders' => $folders, 'files' => $files])->render();
		}

		return $return;
	}

	public function video($id = null){
		$document = VideoGallery::where('active',1)->find($id);
		$return = [];
		$this->videobreadcrumb = [];

		$return['return'] = false;
		$return['content'] = trans('public.ajax.novideo');

		if($id == 'all'){
			$return['return'] = true;
			$folders = Cache::remember('video_category_all.', 60, function(){
				return VideoGallery::where('active',1)->where('boss',0)->orderBy('order','asc')->get()->toArray();
			});

			$return['breadcrumb'] = '<li>'.trans('public.embed.videocategory.title').'</li>';

			$return['content'] = View::make('embed.api.videocategory', ['folders' => $folders, 'files' => []])->render();
		}else{
			$have = $this->getVideoActive($document['boss']);

			if($document && $have){
				$return['return'] = true;
				$folders = Cache::remember('video_category.folder.'.$id, 60, function() use($id){
					return VideoGallery::where('active',1)->where('boss',$id)->orderBy('order','asc')->get()->toArray();
				});
				$files = Cache::remember('video_items.'.$id, 60, function() use($id){
					return Video::where('category',$id)->where('active',1)->orderBy('order','asc')->get()->toArray();
				});

				$this->getVideoIds($document['id'], request()->get('start'));

				ksort($this->videobreadcrumb);

				if(request()->get('type')=='all') {
					$return['breadcrumb'] = '<li class="folder" data-id="all" data-type="video">' . trans('public.embed.videocategory.title') . '</li>';
				}else{
					$return['breadcrumb'] = '';
				}
				foreach($this->videobreadcrumb as $bread){
					$return['breadcrumb'] .= '<li class="folder" data-id="'.$bread['fold'].'" data-type="video">'.$bread['title'].'</li>';
				}
				if(empty($return['breadcrumb'])){
					$return['breadcrumb'] = '<li>'.trans('public.embed.videocategory.title').'</li>';
				}

				$return['content'] = View::make('embed.api.videocategory', ['folders' => $folders, 'files' => $files])->render();
			}
		}

		return $return;
	}
}
