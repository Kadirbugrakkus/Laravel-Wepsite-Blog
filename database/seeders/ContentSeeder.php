<?php

namespace Database\Seeders;

use http\Url;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Faker::create();
        for ($i=0;$i<4;$i++) {
            $title = $faker->sentence(6);
            DB::table('contents')->insert([
                'category_id' => rand(1, 6),
                'title' => $title,
                'image' => $faker->imageUrl(570, 510, 'cats', true, 'Projects'),
                'content' => $faker->paragraph(6),
                "slug" => Str::slug($title, ''),
                'created_at' =>$faker->dateTime('now'),
                'updated_at' => now()
            ]);
        }
    }
}
