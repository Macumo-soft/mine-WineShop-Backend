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
        Schema::create('t_carts', function (Blueprint $table) {
           // Columns
           $table->id()->autoIncrement();
           $table->smallInteger('quantity');
           $table->integer('wine_id');
           $table->integer('user_id');

           // Foreign Key
           $table->foreign('wine_id')->references('id')->on('m_wine');
           $table->foreign('user_id')->references('id')->on('users');

           // Common
           $table->timestamps();
           $table->string('created_user', 50);
           $table->string('updated_user', 50);
           $table->boolean('delete_flg')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_carts');
    }
};
