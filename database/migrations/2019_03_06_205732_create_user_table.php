<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 37)->index();
            $table->integer('account_id')->unsigned()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->integer('rut')->length(9)->unsigned();
            $table->char('rut_dv',1);
            $table->string('address_street')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_department')->nullable();
            $table->string('address_town')->nullable();
            $table->string('phone_landline', 15)->nullable();
            $table->string('phone_mobile', 15)->nullable();
            $table->boolean('is_active')->default(1);

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreign('account_id')->references('id')->on('account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
