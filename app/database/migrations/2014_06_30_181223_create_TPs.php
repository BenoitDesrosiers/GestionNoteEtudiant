<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTPs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tps', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('numero'); //le numéro du tp pour une classe
			$table->integer('classe_id'); //ce TP est pour quelle classe (FK)
			$table->string('nom');
			$table->integer('sur'); // ce TP est sur combien
			$table->integer('poids'); // ce TP compte pour combien sur la note finale
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
		Schema::drop('TPs');
	}

}
