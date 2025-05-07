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
        Schema::create('subscription_conn_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_id'); // Foreign Key to users table
            $table->unsignedBigInteger('user_id'); // Foreign Key to users table
            $table->enum('amt_type', ['m', 'y'])->nullable();
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('subscription_conn_users');
    }
};
