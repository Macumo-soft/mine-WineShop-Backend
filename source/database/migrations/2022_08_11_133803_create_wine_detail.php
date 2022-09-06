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
        Schema::create('m_wine_detail', function (Blueprint $table) {
           // Columns
           $table->id()->autoIncrement();
           $table->smallInteger('centilitre');
           $table->smallInteger('abv');
           $table->text('description');
           $table->integer('wine_id');

           // Foreign Key
           $table->foreign('wine_id')->references('id')->on('m_wine');

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
        Schema::dropIfExists('m_wine_detail');
    }
};
