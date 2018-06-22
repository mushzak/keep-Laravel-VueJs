<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('members', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('group_id')->unsigned();
			$table->integer('onboarding_step')->unsigned()->nullable()->default(1);
			$table->boolean('can_view_all')->default(0);
			$table->boolean('can_edit_all')->default(0);
			$table->string('status')->default('active');
			$table->string('communication_type')->default('daily');
			$table->string('communication_vehicle')->default('email');
			$table->decimal('reminder_wait_1')->default(1.00);
			$table->decimal('reminder_wait_2')->default(1.00);
			$table->text('vision', 65535)->nullable();
			$table->text('values', 65535)->nullable();
			$table->text('mission', 65535)->nullable();
			$table->text('why', 65535)->nullable();
			$table->text('consequences', 65535)->nullable();
			$table->text('personal_bio', 65535)->nullable();
			$table->text('business_bio', 65535)->nullable();
			$table->string('personal_avatar')->nullable();
			$table->string('business_avatar')->nullable();
			$table->string('company_name')->nullable()->default('Business Name');
			$table->string('email')->nullable();
			$table->string('google_drive')->nullable()->default('Not Listed');
			$table->string('phone_1')->nullable()->default('Not Listed');
			$table->string('phone_2')->nullable()->default('Not Listed');
			$table->string('other')->nullable()->default('Not Listed');
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
		Schema::drop('members');
	}

}
