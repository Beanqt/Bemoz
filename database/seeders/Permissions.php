<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = preg_replace('/\s+/', '', '
            {
                "admins":{"read":"on","new":"on","edit":"on","delete":"on"},
                "permissions":{"read":"on","new":"on","edit":"on","delete":"on"},
                "settings":{"edit":"on"},
                "pages":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "menu":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "languages":{"read":"on","new":"on","edit":"on","delete":"on","text":"on","publish":"on","trash":"on"},
                "documentcategory":{"read":"on","new":"on","edit":"on","delete":"on","export":"on","trash":"on"},
                "documentitem":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "gallery":{"read":"on","new":"on","edit":"on","delete":"on","export":"on","trash":"on"},
                "galleryimages":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "videogallery":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "videoitem":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "widget":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "form_content":{"read":"on","new":"on","edit":"on","delete":"on"},
                "form_users":{"read":"on","show":"on","export":"on","delete":"on"},
                "forms":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "fixedcontent":{"read":"on","edit":"on"},
                "slider":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "feed_categories":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "feed_labels":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "feed_items":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "events":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "event_categories":{"read":"on","new":"on","edit":"on","delete":"on","trash":"on"},
                "search":{"read":"on","export":"on"}
            }');

        DB::table('permission')->truncate();
        DB::table('permission')->insert([
            ['title'=>'Admin', 'permissions' => $permission]
        ]);
    }
}
