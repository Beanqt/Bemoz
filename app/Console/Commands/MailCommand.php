<?php namespace App\Console\Commands;

use App\Models\Cron;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailCommand extends Command {
    protected $signature = 'mail:send';
    protected $description = 'Send mail';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        $date = date('Y-m-d H:i:s');
        $next = date('Y-m-d H:i:s', strtotime($date.' -2 hour'));

        $cron = Cron::where('type', 1)->whereRaw('(run IS NULL OR run <= "'.$next.'")')->get();

        if(count($cron)){
            $ids = $cron->pluck('id')->all();
            DB::table('cron')->whereIn('id', $ids)->update(['run' => $date]);

            foreach($cron as $item){
                $data = json_decode($item['content'], true);

                if(isset($data['template'], $data['send'], $data['subject'], $data['data'])){
                    Mail::send($data['template'], $data['data'], function ($message) use ($data) {
                        $sends = explode(',', $data['send']);

                        foreach($sends as $send){
                            $validator = Validator::make(['email' => $send], ['email' => 'required|email']);

                            if(!$validator->fails()){
                                $message->to($send)->subject($data['subject']);
                            }
                        }

                        if(isset($data['attachments'])){
                            foreach($data['attachments'] as $file){
                                $message->attach($file);
                            }
                        }
                    });
                }

                DB::table('cron')->where('id', $item['id'])->delete();
            }
        }
    }
}