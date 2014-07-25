<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSplashesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('splashes', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('location_slug');
            $table->string('destination_url');
            $table->string('asset_url');
            $table->string('title');
            $table->tinyInteger('position')->unsigned;
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
		Schema::drop('splashes');
	}

}
