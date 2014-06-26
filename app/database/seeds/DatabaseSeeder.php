<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        Eloquent::unguard();

        Artwork::truncate();

        $this->call('CataloguesTableSeeder');

        $this->call('CatrefsTableSeeder');

    }

}
