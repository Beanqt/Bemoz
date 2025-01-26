<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(Folders::class);
        $this->call(Permissions::class);
        $this->call(Admins::class);
        $this->call(Language::class);
        $this->call(Settings::class);
        $this->call(Menus::class);
        $this->call(Emails::class);
        $this->call(Pages::class);
        $this->call(Feeds::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
