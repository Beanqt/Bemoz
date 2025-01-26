<?php namespace App\Console\Commands;

use Illuminate\Console\Command;

class SitemapCommand extends Command {
    public $domain;
    public $domain_pattern;
    public $valid_urls = [];
    public $fail_pages = [];
    protected $signature = 'sitemap:generate';
    protected $description = 'Sitemap generate';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        $this->domain = env('APP_URL');
        $this->domain_pattern = str_replace(['/','.'], ['\/','\.'], $this->domain);
        $this->valid_urls[] = '/';
        $this->getUrls('/');

        file_put_contents(public_path('sitemap.xml'), '<?xml version="1.0" encoding="UTF-8"?>'.view('xmls.sitemap')->with('domain', $this->domain)->with('urls', $this->valid_urls)->with('fail', $this->fail_pages)->render());
    }

    public function getUrls($url){
        $new_url = [];

        $context = stream_context_create([
            'http'=>[
                'method' => 'GET',
                'user_agent' => 'sitemap robot'
            ]
        ]);
        $page = @file_get_contents($this->domain.$url, false, $context);

        if($page){
            preg_match_all('/<a.*(href=["\'](\/.*?)["\']|href=["\']+'.$this->domain_pattern.'(.*?)["\'])/', $page, $matches);

            foreach($matches[0] as $key => $match){
                $url = isset($matches[3][$key]) && $matches[3][$key] ? $matches[3][$key] : (isset($matches[2][$key]) && $matches[2][$key] ? $matches[2][$key] : null);

                if(!is_null($url) && strpos($url, 'www.') === false && strpos($url, 'api') === false && strpos($url, 'uploads') === false && strpos($url, 'ckfinder') === false && strpos($url, 'assets') === false && strpos($url, 'images') === false && strpos($url, 'download') === false){
                    $url = str_replace($this->domain, '', $url);

                    if(!in_array($url, $this->valid_urls)){
                        $this->valid_urls[] = $url;
                        $new_url[] = $url;
                    }
                }
            }

            foreach($new_url as $item){
                $this->getUrls($item);
            }
        }else{
            $this->fail_pages[] = $url;
        }
    }
}