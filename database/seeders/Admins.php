<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Admins extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->truncate();
        DB::table('admins')->insert([
            ['name'=>'Ledniczki Tibor', 'email' => 'ledniczki.tibor@positive.hu', 'password' => bcrypt('Kortees12'), 'group' => 1, 'tutorial' => 0],
            ['name'=>'Szolnoki András', 'email' => 'szolnoki.andras@positive.hu', 'password' => bcrypt('Kortees12'), 'group' => 1, 'tutorial' => 0],
            ['name'=>'Lukács Ádám', 'email' => 'lukacs.adam@positive.hu', 'password' => bcrypt('Kortees12'), 'group' => 1, 'tutorial' => 0],
            ['name'=>'Bárczi Brigitta', 'email' => 'barczi.brigitta@positive.hu', 'password' => bcrypt('Kortees12'), 'group' => 1, 'tutorial' => 0],
            ['name'=>'Takács Bence', 'email' => 'takacs.bence@positive.hu', 'password' => bcrypt('Kortees12'), 'group' => 1, 'tutorial' => 0]
        ]);
    }
}
