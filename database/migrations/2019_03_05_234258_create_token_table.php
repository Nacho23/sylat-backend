<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTokenTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('token', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('account_id')->unsigned()->index();
			$table->char('token', 37)->unique('token_UNIQUE');
			$table->string('type', 45)->default('access');
			$table->text('details', 65535)->nullable();
			$table->dateTime('created_dt');
			$table->dateTime('expire_dt');
			$table->dateTime('updated_dt')->nullable();

			$table->foreign('account_id')->unsigned()->references('id')->on('account');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('token');
	}

}
