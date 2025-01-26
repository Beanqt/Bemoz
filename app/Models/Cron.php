<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Cron extends Model {

    protected $table = 'cron';
    public $timestamps = false;

    public $simple_type = [
        1 => 'Email kiküldés',
        2 => 'Esemény xml',
    ];

    public static function saveData($type = 0, $content = []){
        if(env('APP_CRON')){
            $model = new self();
            $model->type = $type;
            $model->content = json_encode($content);
            $model->save();

            return $model;
        }elseif($type == 1){
            Mail::send($content['template'], $content['data'], function ($message) use ($content) {
                $sends = explode(',', $content['send']);

                foreach($sends as $send){
                    if(filter_var($send, FILTER_VALIDATE_EMAIL)){
                        $message->to($send)->subject($content['subject']);
                    }
                }

                if(isset($content['attachments'])){
                    foreach($content['attachments'] as $file){
                        $message->attach($file);
                    }
                }
            });
        }
    }
}
