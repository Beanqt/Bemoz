<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class Emails extends Model {
    use LogTrait;

    public static $name = 'emails';
    public static $permissions = ['read', 'edit'];
    public $validator = [];
    public $data;
    public $template;

    protected $table = 'emails';
    public $lists = [
        'title',
    ];

    public static $shortcodes = [
        1 => ['name','password_reminder_link'],
        2 => ['name','login_url','password'],
    ];

    public function isValid($e, $edit = null){
        $messages = [
            'required' => trans('admin.alert.required')
        ];
        $rules = [
            'title' => 'required',
        ];

        $validator = Validator::make($e,$rules,$messages);

        if(!$validator->fails()){
            return true;
        }

        session()->flash('error', trans('admin.alert.haveError'));
        $this->validator = $validator;
        return false;
    }

    public function saveData($e, $data = null){
        if($data){
            $model = self::find($data['id']);
        }else{
            $model = new self();
        }

        $model->title = $e['title'];
        $model->subject = json_encode($e['subject']);
        $model->content = json_encode($e['content']);
        $model->save();

        return $model;
    }

    public function data($data){
        $this->data = $data;

        return $this;
    }

    public function template($template){
        $this->template = 'emails.'.$template;

        return $this;
    }

    public function send($emails){
        $subject = $this->render(getLangString($this->subject));
        $this->content = $this->render(getLangString($this->content));

        $cron['template'] = $this->template;
        $cron['send'] = $emails;
        $cron['subject'] = $subject;
        $cron['data'] = ['content' => $this->content, 'other' => $this->data];

        if(isset($this->data['attachments'])){
            $cron['attachments'] = $this->data['attachments'];
        }

        Cron::saveData(1, $cron);
    }

    public function render($content){
        $mit = [];
        $mire = [];

        foreach(self::$shortcodes[$this->id] as $item){
            if(isset($this->data[$item])){
                $mit[] = '['.$item.']';
                $mire[] = $this->data[$item];
            }
        }

        if($this->id == 1){
            $mit[] = '[password_reminder_link]';
            $mire[] = '<a href="'.route('reminder.token', $this->data['token']).'" target="_blank">'.trans('public.login.reminder.link').'</a>';
        }elseif($this->id == 2){
            $login = Translates::where('item', 'login.slug')->where('group', 'public')->where('locale', App::getLocale())->first();

            $mit[] = '[login_url]';
            $mire[] = '<a href="'.asset($login['text']).'">'.asset($login['text']).'</a>';
        }

        return str_replace($mit, $mire, $content);
    }
}