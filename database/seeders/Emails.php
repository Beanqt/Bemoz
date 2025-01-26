<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Emails extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('emails')->truncate();
        DB::table('emails')->insert([
            ['title'=>'Jelszó emlékeztető', 'subject'=>'{"hu":"Jelsz\u00f3 eml\u00e9keztet\u0151"}', 'content'=>'{"hu":"<p>Tisztelt [name]!<\/p>\r\n\r\n<p>&Ouml;n &uacute;j jelsz&oacute;t igy&eacute;nyelt.<\/p>\r\n\r\n<p>Ezen a linken megadhatja &uacute;j jelszav&aacute;t: <strong>[password_reminder_link]<\/strong><\/p>"}'],
            ['title'=>'Jelszó kiküldése a felhasználónak', 'subject'=>'{"hu":"Bejelentkez\u00e9shez a jelsz\u00f3"}', 'content'=>'{"hu":"<p>Tisztelt [name]!<\/p>\r\n\r\n<p>Hozz&eacute;f&eacute;r&eacute;st kapott, amit a k&ouml;vetkez\u0151 linken el&eacute;rhet:<br \/>\r\n[login_url]<\/p>\r\n\r\n<p>Az &ouml;n jelszava a k&ouml;vetkez\u0151:&nbsp;<strong>[password]<\/strong><\/p>"}']
        ]);
    }
}
