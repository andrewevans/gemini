<?php

use Faker\Factory as Faker;

class CataloguesTableSeeder extends Seeder {

    public function run()
    {

        $faker = Faker::create('en_US');

        foreach (range(1,4) as $index) {

            Catalogue::create([
                'artist_id' => 1001,
                'slug' => $faker->sentence(rand(3,6)),
                'title' => $faker->sentence(rand(1,15)),
                'url_slug' => $faker->sentence(rand(3,6)),
                'meta_description' => $faker->sentence(rand(6,20)),
            ]);
        }
    }
}