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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger("order_id");
            $table->foreign('order_id')->references('id')->on('options');
            $table->unsignedBigInteger("location_id");
            $table->foreign('location_id')->references('id')->on('locations');
            $table->unsignedBigInteger("company_id");
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string("option");
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
        Schema::dropIfExists('orders');
    }
};
