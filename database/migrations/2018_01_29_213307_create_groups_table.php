<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('account_id')->unsigned();
			$table->integer('facilitator_id')->unsigned();
			$table->string('name');
			$table->string('slug')->unique();
			$table->string('description')->nullable();
			$table->string('avatar')->nullable();
			$table->text('purpose', 65535)->nullable();
			$table->text('slogan', 65535)->nullable();
			$table->text('location', 65535)->nullable();
			$table->text('contact', 65535)->nullable();
			$table->text('welcome', 65535)->nullable();
			$table->string('default_notification_frequency')->default('daily');
			$table->string('default_notification_channel')->default('email');
			$table->boolean('is_using_ask')->default(1);
			$table->boolean('is_using_backstory')->default(1);
			$table->boolean('is_using_commitment')->default(1);
			$table->boolean('is_using_outcome')->default(1);
			$table->boolean('is_using_goal')->default(1);
			$table->boolean('is_using_big_picture')->default(1);
			$table->boolean('is_using_personal_motivation')->default(1);
			$table->boolean('is_using_professional_background')->default(1);
			$table->string('ask_label')->default('Ask');
			$table->string('backstory_label')->default('Backstory');
			$table->string('commitment_label')->default('Commitment');
			$table->string('outcome_label')->default('Outcome');
			$table->string('goal_label')->default('Goal');
			$table->string('objective_label')->default('Objective');
			$table->string('vision_label')->default('Vision');
			$table->string('values_label')->default('Values');
			$table->string('mission_label')->default('Mission');
			$table->string('why_label')->default('Why');
			$table->string('consequences_label')->default('Consequences');
			$table->string('company_name_label')->default('Company Name');
			$table->string('company_bio_label')->default('Company Bio');
			$table->integer('current_process')->unsigned()->default(1);
			$table->integer('check_in_interval')->unsigned()->default(0);
			$table->integer('pace')->unsigned()->default(0);
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
		Schema::drop('groups');
	}

}
