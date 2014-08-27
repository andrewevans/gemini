<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCatrefRelationField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('artworks', function(Blueprint $table)
		{
            $table->string('catref_id')->after('artist_id');
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
            $table->dropColumn('catref_id');
		});
	}

}
