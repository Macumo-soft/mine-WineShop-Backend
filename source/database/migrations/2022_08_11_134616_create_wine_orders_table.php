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
        Schema::create('t_ordered_wine', function (Blueprint $table) {
           // Columns
           $table->id()->autoIncrement();
           $table->string('quantity', 3);
           $table->timestamp('delivery_date');
           $table->integer('wine_id');
           $table->integer('user_id');

           // Foreign Key
           $table->foreign('wine_id')->references('id')->on('m_wine');
           $table->foreign('user_id')->references('id')->on('t_users');

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
        Schema::dropIfExists('t_wine_orders');
    }
};
