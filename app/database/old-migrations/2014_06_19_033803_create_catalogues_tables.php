<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCataloguesTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('catalogues', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('artist_id')->unsigned();
            $table->string('slug');
            $table->string('title');
            $table->string('url_slug');
            $table->string('meta_description');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('catalogues');
	}

}
