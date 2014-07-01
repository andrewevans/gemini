<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilterToArtistBioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('artists_bios', function(Blueprint $table)
		{
			//
            $table->string('filter')->after('description');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('artists_bios', function(Blueprint $table)
		{
			//
            $table->dropColumn('filter');
		});
	}

}
