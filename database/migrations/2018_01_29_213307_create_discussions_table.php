<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDiscussionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('discussions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('author_id')->unsigned()->nullable()->index();
			$table->integer('target_id')->unsigned();
			$table->string('target_type');
			$table->string('title');
			$table->text('body', 65535);
			$table->boolean('is_urgent')->default(0);
			$table->dateTime('author_read_at')->nullable();
			$table->dateTime('target_read_at')->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->index(['target_id','target_type']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('discussions');
	}

}
