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
           $table->string('centilitre', 3);
           $table->string('abv', 2);
           $table->string('country', 15);
           $table->text('description');
           $table->integer('wine_id');
           $table->integer('wine_type_id');

           // Foreign Key
           $table->foreign('wine_id')->references('id')->on('m_wine');
           $table->foreign('wine_type_id')->references('id')->on('m_wine_type');

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
        Schema::dropIfExists('m_wine_detail');
    }
};
