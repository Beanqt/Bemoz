<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Menus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu')->truncate();
        DB::table('menu')->insert([
            ['lang'=>1, 'title'=>'Teszt', 'url'=>'/', 'type'=>1, 'boss'=>0, 'order'=>1,'data'=>'[]','main_type'=>0,'active'=>1,'public_at'=>'2017-01-01 00:00:00'],
            ['lang'=>1, 'title'=>'Teszt 2', 'url'=>'/', 'type'=>1, 'boss'=>0, 'order'=>2,'data'=>'[]','main_type'=>0,'active'=>1,'public_at'=>'2017-01-01 00:00:00'],
            ['lang'=>1, 'title'=>'Teszt 3', 'url'=>'/', 'type'=>1, 'boss'=>0, 'order'=>3,'data'=>'[]','main_type'=>0,'active'=>1,'public_at'=>'2017-01-01 00:00:00'],
            ['lang'=>1, 'title'=>'Almenu', 'url'=>'/', 'type'=>1, 'boss'=>1, 'order'=>4,'data'=>'[]','main_type'=>0,'active'=>1,'public_at'=>'2017-01-01 00:00:00'],
            ['lang'=>1, 'title'=>'Almenu 2', 'url'=>'/', 'type'=>1, 'boss'=>1, 'order'=>5,'data'=>'[]','main_type'=>0,'active'=>1,'public_at'=>'2017-01-01 00:00:00'],

            ['lang'=>1, 'title'=>'Menu 1', 'url'=>'/', 'type'=>1, 'boss'=>0, 'order'=>1,'data'=>'[]','main_type'=>1,'active'=>1,'public_at'=>'2017-01-01 00:00:00'],
            ['lang'=>1, 'title'=>'Menu 2', 'url'=>'/', 'type'=>1, 'boss'=>0, 'order'=>2,'data'=>'[]','main_type'=>1,'active'=>1,'public_at'=>'2017-01-01 00:00:00'],
            ['lang'=>1, 'title'=>'Menu 3', 'url'=>'/', 'type'=>1, 'boss'=>0, 'order'=>3,'data'=>'[]','main_type'=>1,'active'=>1,'public_at'=>'2017-01-01 00:00:00'],
        ]);
    }
}
