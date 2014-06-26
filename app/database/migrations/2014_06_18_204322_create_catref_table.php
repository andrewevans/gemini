<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatrefTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('catref', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('catalogue_id')->unsigned();
            $table->string('reference_num');
            $table->string('title');
            $table->string('title_ext');
            $table->string('size');
            $table->string('signed');
            $table->string('edition');
            $table->string('medium');
            $table->string('therest');
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
		Schema::drop('catref');
	}

}
