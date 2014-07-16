<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenreToArtistsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('artists', function(Blueprint $table)
		{
            $table->string('genre')->after('url_slug');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('artists', function(Blueprint $table)
		{
            $table->dropColumn('genre');
		});
	}

}
