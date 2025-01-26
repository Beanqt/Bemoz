<?php namespace App\Http\Controllers\Api;

use App\Models\DocumentCategory;
use App\Models\DocumentDownload;
use App\Models\DocumentItem;

class DownloadController {
	public $active = false;
	public function download($folder = null, $slug = null){
		$document = DocumentItem::where('category', $folder)->where('slug',$slug)->where('active',1)->first();
		if($document){
			$this->getFolderActive($document['category']);
			$filePath=public_path('uploads/documentitem/'.$document['category'].'/'.$document['file']);

			if(($folder == 0 || $this->active) && file_exists($filePath)){
				$model = new DocumentDownload();
				$model->document_id = $document['id'];
				$model->save();

				$ext = explode(".",$document['file']);
				$ext = end($ext);

				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.basename($document['slug'].'.'.$ext).'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($filePath));
				readfile($filePath);
			}else{
				return redirect()->back();
			}
		}else{
			return redirect()->back();
		}
	}
	public function getFolderActive($id) {
		$sub = DocumentCategory::find($id);
		if($sub){
			if($sub['active'] == 1){
				$this->active = true;
				if(!is_null($sub['boss'])) {
					$this->getFolderActive($sub['boss']);
				}
			}else{
				$this->active = false;
				return false;
			}
		}
	}
}

