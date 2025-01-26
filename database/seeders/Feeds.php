<?php namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;

class Feeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        DB::table('feed_categories')->truncate();
        DB::table('feed_labels')->truncate();
        DB::table('feed_items')->truncate();
        DB::table('feed_item_labels')->truncate();

        foreach(range(1, 12) as $key => $item){
            $title = ucfirst(implode(' ', $faker->words));

            DB::table('feed_categories')->insert([
                'lang' => 1,
                'title' => $title,
                'slug' => slug($title),
                'active' => rand(0,1),
                'order' => $key
            ]);
        }

        foreach(range(1, 4) as $key => $item){
            $title = ucfirst(implode(' ', $faker->words));

            DB::table('feed_labels')->insert([
                'lang' => 1,
                'title' => $title,
                'slug' => slug($title),
                'active' => rand(0,1),
                'order' => $key
            ]);
        }

        foreach(range(1, 80) as $item) {
            $content = $faker->text(1000);
            $title = ucfirst(implode(' ', $faker->words));

            $id = DB::table('feed_items')->insertGetId([
                'lang' => 1,
                'category' => rand(1, 12),
                'title' => $title,
                'slug' => slug($title),
                'content' => '[{"type":"content","content":"'.$content.'"},{"template":"'.rand(1,2).'"}]',
                'public_at' => $faker->dateTime(),
                'active' => rand(0,1),
                'auth' => rand(0,1)
            ]);

            $labels = [];

            foreach(range(1, rand(2,4)) as $label){
                $labels[] = [
                    'item' => $id,
                    'label' => rand(1,4)
                ];
            }

            DB::table('feed_item_labels')->insert($labels);
        }
    }
}
