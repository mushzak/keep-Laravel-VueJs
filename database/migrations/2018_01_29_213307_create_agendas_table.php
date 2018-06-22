<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agendas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('meeting_id')->unsigned();
			$table->text('name', 65535);
			$table->integer('duration')->unsigned()->default(0);
			$table->integer('order')->unsigned()->default(0);
			$table->boolean('is_facilitator_only')->default(0);
			$table->softDeletes();
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
		Schema::drop('agendas');
	}

}
