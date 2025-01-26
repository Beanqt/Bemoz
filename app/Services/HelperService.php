<?php namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Cache;
use App\Models\FixedContent;
use App\Models\PartnerItem;

class HelperService extends Controller
{
    public function getFixedContent($id){
        $fixedContent = Cache::remember('fixed_content.'.$id, 60, function() use($id) {
            return FixedContent::find($id);
        });

        if($fixedContent) {
            $fixedContent['title'] = getLangString($fixedContent['title']);
            $fixedContent['content'] = $this->parseShortCode(getLangString($fixedContent['content']));
            $fixedContent['seo_title'] = getLangString($fixedContent['seo_title']);
            $fixedContent['seo_desc'] = getLangString($fixedContent['seo_desc']);
            $fixedContent['seo_keywords'] = getLangString($fixedContent['seo_keywords']);
        }

        return $fixedContent;
    }

    public function getContent($string, $template = 1){
        return $this->parseContent($string, $template);
    }

    public function getSimpleContent($string){
        return $this->parseShortCode($string);
    }

    public function getPartners(){
        $partners = Cache::remember('partner_items', 60, function(){
            return PartnerItem::where('active', 1)->orderBy('order', 'asc')->get();
        });

        return $partners;
    }
}