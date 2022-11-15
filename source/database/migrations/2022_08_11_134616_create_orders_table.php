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
        Schema::create('t_orders', function (Blueprint $table) {
           // Columns
           $table->id()->autoIncrement();
           $table->integer('user_id');
           $table->timestamp('delivery_date');

           // Foreign Key
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
        Schema::dropIfExists('t_orders');
    }
};
