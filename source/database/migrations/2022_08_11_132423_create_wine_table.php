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
        Schema::create('m_wine', function (Blueprint $table) {
            // Columns
            $table->id()->autoIncrement();
            $table->string('name', 100);
            $table->string('img_url', 200);
            $table->float('price', 5, 2);
            $table->integer('wine_type_id');

            // Foreign Key
            $table->foreign('wine_type_id')->references('id')->on('m_wine_type');

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
        // Schema::dropIfExists('m_wine');
    }
};
