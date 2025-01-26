<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Settings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pageoption')->truncate();
        DB::table('pageoption')->insert([
            ['lang' => 1, 'name' => 'seo', 'value' => '{"title":"","keywords":"","desc":""}'],
            ['lang' => 1, 'name' => 'cookie', 'value' => '{"title":"","desc":"","btn":"","link":"","ok":""}'],
            ['lang' => 0, 'name' => 'social', 'value' => '{"facebook":"","youtube":"","instagram":"","linkedin":"","google":"","twitter":""}'],
            ['lang' => 0, 'name' => 'ga', 'value' => ''],
            ['lang' => 0, 'name' => 'service', 'value' => ''],
            ['lang' => 0, 'name' => 'javascript', 'value' => ''],
            ['lang' => 0, 'name' => 'pixel', 'value' => ''],
            ['lang' => 0, 'name' => 'map', 'value' => ''],
            ['lang' => 0, 'name' => 'upload_image', 'value' => '100'],
            ['lang' => 0, 'name' => 'upload_document', 'value' => '100'],
            ['lang' => 0, 'name' => 'upload_video', 'value' => '100']
        ]);
    }
}
