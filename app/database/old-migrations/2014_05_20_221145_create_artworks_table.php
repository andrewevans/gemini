<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtworksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('artworks', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('artist_id')->unsigned();
            $table->foreign('artist_id')->references('id')->on('artists');
            $table->integer('price');
            $table->string('title');
            $table->string('title_short');
            $table->string('series');
            $table->string('series_short');
            $table->string('medium');
            $table->string('medium_short');
            $table->string('after');
            $table->string('signature');
            $table->string('condition');
            $table->string('size_img');
            $table->string('size_sheet');
            $table->string('size_framed');
            $table->string('tagline');
            $table->string('reference');
            $table->string('framing');
            $table->tinyInteger('price_on_req');
            $table->tinyInteger('sold');
            $table->tinyInteger('hidden');
            $table->tinyInteger('onhold');
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
		Schema::drop('artworks');
	}

}
