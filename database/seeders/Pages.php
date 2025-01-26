<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;

class Pages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('pages')->truncate();

        foreach(range(1, 100) as $index) {
            $content = $faker->text(1000);
            $title = ucfirst(implode(' ', $faker->words));

            DB::table('pages')->insert([
                'lang' => 1,
                'title' => $title,
                'slug' => slug($title),
                'content' => '[{"type":"content","content":"'.$content.'"},{"template":"'.rand(1,2).'"}]',
                'public_at' => $faker->dateTime(),
                'active' => rand(0,1),
                'auth' => rand(0,1)
            ]);
        }
    }
}
