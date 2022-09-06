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
        Schema::create('t_users', function (Blueprint $table) {
            // Columns
            $table->id()->autoIncrement();
            $table->string('email_address', 100);
            $table->string('username', 50);
            $table->string('password', 64);

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
        // Schema::dropIfExists('t_users');
    }
};
