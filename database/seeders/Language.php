<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Language extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = env('DEFAULT_LANG') == 'hu' ? 'Magyar' : (env('DEFAULT_LANG') == 'en' ? 'Angol' : 'Default');

        DB::table('translator_translations')->truncate();
        DB::table('translator_languages')->truncate();
        DB::table('translator_languages')->insert([
            ['name'=>$title, 'locale' => env('DEFAULT_LANG'), 'active'=>1, 'order' => 0]
        ]);
    }
}
