<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('active_group_id')->unsigned()->nullable();
			$table->string('name');
			$table->string('password');
			$table->string('email')->unique();
			$table->string('phone')->nullable();
			$table->text('text_phone')->nullable();
			$table->boolean('is_using_2fa')->default(0);
			$table->string('address')->nullable();
			$table->string('business')->nullable();
			$table->boolean('is_admin')->default(0);
			$table->boolean('should_not_notify')->default(0);
			$table->string('remember_token', 100)->nullable();
			$table->dateTime('last_checked_in_at')->nullable();
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
		Schema::drop('users');
	}

}
