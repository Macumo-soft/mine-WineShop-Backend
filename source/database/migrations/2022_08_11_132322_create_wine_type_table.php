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
        Schema::create('m_wine_type', function (Blueprint $table) {
            // Columns
            $table->id()->autoIncrement();
            $table->string('name', 10);

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
        Schema::dropIfExists('m_wine_type');
    }
};
