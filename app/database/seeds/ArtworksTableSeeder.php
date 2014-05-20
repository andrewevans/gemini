<?php

use Faker\Factory as Faker;

class ArtworksTableSeeder extends Seeder {

    public function run()
    {

        $faker = Faker::create('en_US');

        foreach (range(1,10) as $index) {

            Artwork::create([
                'artist_id' => 1,
                'price' => $faker->numberBetween(1000,150000),
                'title' => $faker->sentence(rand(1,15)),
                'medium' => $faker->sentence(rand(2,15)),
                'series' => $faker->sentence(rand(0,6)),
                'signature' => $faker->sentence(rand(0,15)),
                'condition' => $faker->sentence(rand(2,8)),
                'after' => $faker->sentence(rand(0,1)),
                'sold' => $faker->numberBetween(0,3),
                'hidden' => $faker->numberBetween(0,2),
                'onhold' => $faker->numberBetween(0,1),

            ]);
        }
    }
}