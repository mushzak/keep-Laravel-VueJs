<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMeetingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meetings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('group_id')->unsigned();
			$table->integer('current_participant_id')->unsigned()->nullable();
			$table->integer('current_agenda_id')->unsigned()->nullable();
			$table->string('subject');
			$table->boolean('was_facilitator_notified_of_unaccepted')->default(0);
			$table->boolean('was_participants_reminded')->default(0);
			$table->dateTime('reminds_at')->nullable();
			$table->dateTime('starts_at')->nullable();
			$table->dateTime('started_at')->nullable();
			$table->dateTime('ends_at')->nullable();
			$table->dateTime('ended_at')->nullable();
			$table->dateTime('should_advance_at')->nullable();
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
		Schema::drop('meetings');
	}

}
