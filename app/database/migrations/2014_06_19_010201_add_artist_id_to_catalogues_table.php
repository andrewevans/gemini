<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArtistIdToCataloguesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('catalogues', function(Blueprint $table)
		{
			//
            $table->integer('artist_id')->unsigned()->after('id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('catalogues', function(Blueprint $table)
		{
			//
            $table->dropColumn('artist_id');

        });
	}

}
