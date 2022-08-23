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
        Schema::create('m_wine_delivery', function (Blueprint $table) {
            // Columns
            $table->id()->autoIncrement();
            $table->string('stocks', 3);
            $table->string('delivery_period', 2);
            $table->integer('wine_detail_id');

            // Foreign Key
            $table->foreign('wine_detail_id')->references('id')->on('m_wine_detail');

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
        Schema::dropIfExists('m_wine_delivery');
    }
};
