<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcknowledgementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acknowledgements', function(Blueprint $table)
		{
			$table->integer('discussion_id')->unsigned()->index();
			$table->integer('member_id')->unsigned()->index();
			$table->timestamps();
			$table->primary(['discussion_id','member_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('acknowledgements');
	}

}
