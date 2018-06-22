<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateObjectivesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('objectives', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('goal_id')->unsigned();
			$table->text('name', 65535);
			$table->dateTime('due_at')->nullable();
			$table->dateTime('completed_at')->nullable();
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
		Schema::drop('objectives');
	}

}
