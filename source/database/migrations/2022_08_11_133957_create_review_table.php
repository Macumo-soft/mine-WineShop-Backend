<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_reviews', function (Blueprint $table) {
           // Columns
           $table->id()->autoIncrement();
           $table->string('review_score', 1);
           $table->text('review_comment');
           $table->integer('user_id');
           $table->integer('wine_id');

           // Foreign Key
           $table->foreign('user_id')->references('id')->on('t_users');
           $table->foreign('wine_id')->references('id')->on('m_wine');

           // Common
           $table->timestamps();
           $table->string('created_user', 50);
           $table->string('updated_user', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_reviews');
    }
};
