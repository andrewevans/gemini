<?php

use Faker\Factory as Faker;

class CatrefsTableSeeder extends Seeder {

    public function run()
    {

        $faker = Faker::create('en_US');

        foreach (range(1,40) as $index) {

            Catref::create([
                'catalogue_id' => 1001,
                'reference_num' => $faker->buildingNumber,
                'title' => $faker->sentence(rand(1,15)),
                'medium' => $faker->sentence(rand(2,15)),

            ]);
        }
    }
}