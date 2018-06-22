<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('manager_id')->unsigned();
			$table->string('name');
			$table->string('business_name')->nullable();
			$table->string('phone')->nullable();
			$table->string('email')->nullable();
			$table->string('plan')->default('free');
			$table->boolean('use_custom_branding')->default(0);
			$table->string('custom_logo')->nullable();
			$table->boolean('is_using_2fa')->default(0);
			$table->string('billing')->nullable();
			$table->string('enabled_features')->nullable();
			$table->boolean('is_current')->default(0);
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
		Schema::drop('accounts');
	}

}
