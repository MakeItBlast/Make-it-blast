<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('payed_for', ['subscription', 'extra_credit', 'service'])->default('subscription');
            $table->unsignedBigInteger('coupon_id')->nullable(); // Made nullable
            $table->string('payment_method');
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('status');
            $table->string('currency')->default('USD');
            $table->text('response_data')->nullable();
            $table->string('gateway_reference')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->text('description')->nullable();
            $table->enum('refund_status', ['not_refunded', 'pending', 'refunded'])->default('not_refunded');
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('transaction_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('set null'); // Changed to set null
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};