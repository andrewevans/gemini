<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEditionsToArtists extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('artworks', function(Blueprint $table)
		{
			//
            $table->string('edition')->after('medium_short');
            $table->string('edition_short')->after('edition');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('artworks', function(Blueprint $table)
		{
			//
            $table->dropColumn('edition');
            $table->dropColumn('edition_short');
        });
	}

}
