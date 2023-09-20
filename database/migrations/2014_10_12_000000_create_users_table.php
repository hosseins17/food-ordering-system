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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->smallInteger('role')->default('0');//0 means normal user and 1 means admin user
            $table->smallInteger('type')->default('0');//0 means normal user and 1 means gharardadi user and 2 means soldier
            $table->smallInteger('company')->default('1');//1 means seraj
            $table->smallInteger('default_location')->default('0');//0 means tarasht
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
