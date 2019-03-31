<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 37)->index();
            $table->string('title');
            $table->string('body');
            $table->integer('category_id')->unsigned()->index();
            $table->integer('user_sender_id')->unsigned()->index();
            $table->integer('user_receiver_id')->unsigned()->index();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();

            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('user_sender_id')->references('id')->on('user');
            $table->foreign('user_receiver_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post');
    }
}
