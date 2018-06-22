<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommitmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('commitments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('member_id')->unsigned();
			$table->integer('process_number')->unsigned();
			$table->text('name', 65535)->nullable();
			$table->text('ask', 65535)->nullable();
			$table->text('backstory', 65535)->nullable();
			$table->text('outcome', 65535)->nullable();
			$table->dateTime('completed_at')->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->unique(['member_id','process_number']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('commitments');
	}

}
