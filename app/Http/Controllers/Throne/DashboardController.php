<?php namespace App\Http\Controllers\Throne;

use App\Models\Activity;
use App\Models\Visitor;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public $start;
    public $end;

    public function index() {
        $e = request()->all();

        $this->start = isset($e['start']) ? $e['start'] : date('Y-m-d', strtotime('-1 month'));
        $this->end = isset($e['end']) ? $e['end'] : date('Y-m-d');

        $active = Activity::where('updated_at','>=',date('Y-m-d H:i:s', strtotime('-2 minutes')))->count();
        $new_users = Activity::whereRaw('DATE(created_at) = "'.date('Y-m-d').'"')->count();
        $return_users = Activity::whereRaw('DATE(updated_at) != DATE(created_at)')->whereRaw('DATE(created_at) >= "'.$this->start.'" AND DATE(created_at) <= "'.$this->end.'"')->count();
        $all_users = Activity::whereRaw('DATE(created_at) >= "'.$this->start.'" AND DATE(created_at) <= "'.$this->end.'"')->count();
        $all_show = Visitor::whereRaw('DATE(created_at) >= "'.$this->start.'" AND DATE(created_at) <= "'.$this->end.'"')->count();
        $pages = Visitor::selectRaw('page, count(page) as counted')->whereRaw('DATE(created_at) >= "'.$this->start.'" AND DATE(created_at) <= "'.$this->end.'"')->groupBy('page')->orderBy('counted', 'desc')->limit(10)->get();

        $user_data = [];
        if($this->getMonths() > 1){
            $user_data = Activity::selectRaw(
                'date_format(created_at,"%Y-%m") as datum_at, COUNT(id) as count'
            )->whereRaw('DATE(created_at) >= "'.$this->start.'" AND DATE(created_at) <= "'.$this->end.'"')->groupBy('datum_at')->get();
        }elseif($this->getDays()){
            $user_data = Activity::selectRaw(
                'DATE(created_at) as datum_at, COUNT(id) as count'
            )->whereRaw('DATE(created_at) >= "'.$this->start.'" AND DATE(created_at) <= "'.$this->end.'"')->groupBy('datum_at')->get();
        }elseif($this->getTimes()){
            $user_data = Activity::selectRaw(
                'date_format(created_at,"%Y-%m-%d %H:%i:%s") as datum_at, date_format(created_at,"%Y-%m-%d %H") as datum_at2, COUNT(id) as count'
            )->whereRaw('DATE(created_at) >= "'.$this->start.'" AND DATE(created_at) <= "'.$this->end.'"')->groupBy('datum_at2')->get();
        }

        $device = ['mobil' => 0, 'tablet' => 0, 'computer' => 0];
        $device['mobil'] = Visitor::select('id')->where('device', 3)->whereRaw('DATE(created_at) >= "'.$this->start.'" AND DATE(created_at) <= "'.$this->end.'"')->count();
        $device['tablet'] = Visitor::select('id')->where('device', 2)->whereRaw('DATE(created_at) >= "'.$this->start.'" AND DATE(created_at) <= "'.$this->end.'"')->count();
        $device['computer'] = Visitor::select('id')->where('device', 1)->whereRaw('DATE(created_at) >= "'.$this->start.'" AND DATE(created_at) <= "'.$this->end.'"')->count();
        $browser = Visitor::selectRaw('browser, count(browser) as counted')->whereRaw('DATE(created_at) >= "'.$this->start.'" AND DATE(created_at) <= "'.$this->end.'"')->groupBy('browser')->get();

        $all_devices = Visitor::select('id')->whereRaw('DATE(created_at) >= "'.$this->start.'" AND DATE(created_at) <= "'.$this->end.'"')->count();

        View::share('start', $this->start);
        View::share('end', $this->end);
        View::share('userChart', $this->getDataMonth($user_data));
        View::share('device',$device);
        View::share('active',$active);
        View::share('pages',$pages);
        View::share('new_users',$new_users);
        View::share('return_users',$return_users);
        View::share('all_users',$all_users);
        View::share('all_show',$all_show);
        View::share('all_devices',$all_devices);
        View::share('browsers',$browser);

        $browser_type = [
            1 => 'Internet Explorer',
            2 => 'Opera',
            3 => 'Firefox',
            4 => 'Chrome',
            5 => 'Safari',
        ];
        View::share('browser_type',$browser_type);
        return $this->view('throne.layouts.dashboard');
    }

    public function getDataMonth($data){
        $day = false;
        $time = false;

        $elements = $this->getMonths();

        if($elements < 2){
            $elements = $this->getDays();

            if($elements == 0){
                $time = true;
                $elements = $this->getTimes();
            }else{
                $day = true;
            }
        }

        $value = [];
        for($i = 0; $i <= $elements; $i++){
            $d = new \DateTime($this->start);
            if($time){
                $d->modify('+'.$i.' hour');
                $next = $d->format('H');
            }elseif($day){
                $d->modify('+'.$i.' day');
                $next = $d->format('Y-m-d');
            }else{
                $d->modify('first day of +'.$i.' month');
                $next = $d->format( 'Y-m' );
            }
            $value[$next] = 0;

            foreach($data as $item){
                if($next == date('Y-m', strtotime($item['datum_at'])) || ($next == date('Y-m-d', strtotime($item['datum_at'])) && $day) || ($next == date('H', strtotime($item['datum_at'])) && $time)){
                    if(isset($item['count'])){
                        $value[$next] = $item->count;
                    }else{
                        $value[$next]++;
                    }
                }
            }
        }

        return $value;
    }

    public function getMonths(){
        $start = $this->start.' 00:00:00';
        $end = $this->end.' 23:59:59';
        $months = (date( 'Y', strtotime($end)) - date('Y', strtotime($start))) * 12;
        $months += date('m', strtotime($end) ) - date('m', strtotime($start));

        return $months;
    }
    public function getDays(){
        $start = new \DateTime($this->start);
        $last = new \DateTime($this->end);

        $days = $start->diff($last)->format("%a");

        return $days;
    }
    public function getTimes(){
        $start = $this->start.' 00:00:00';
        $end = $this->end.' 23:59:59';
        $times = date('H', strtotime($end)) - date('H', strtotime($start));

        return $times;
    }

    public function useronline(){
        $return['user'] = Activity::where('updated_at','>=',date('Y-m-d H:i:s', strtotime('-2 minutes')))->count();

        echo json_encode($return);
    }

    public function notPermission(){
        return $this->view('throne.layouts.permission');
    }
}
