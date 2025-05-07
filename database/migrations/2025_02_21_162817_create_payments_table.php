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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_id'); 
            $table->enum('payed_for', ['subscription', 'extra_credit', 'service',])->default('subscription'); // Transaction status
            $table->unsignedBigInteger('coupon_id');
            $table->string('payment_method'); // Example: credit card, paypal, etc.
            $table->string('transaction_id')->unique(); // Unique ID for the transaction (from the payment gateway)
            $table->decimal('amount', 10, 2); // Payment amount
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending'); // Transaction status
            $table->string('currency')->default('USD'); // Currency used for the transaction
            $table->text('response_data')->nullable(); // Store additional response data from the payment gateway
            $table->string('gateway_reference')->nullable(); // Gateway-specific reference
            $table->timestamp('payment_date')->nullable(); // Date the payment was processed
            $table->text('description')->nullable(); // Description of the transaction
            $table->enum('refund_status', ['not_refunded', 'pending', 'refunded'])->default('not_refunded'); // Track refund status
            $table->timestamps();
        
            $table->index(['user_id', 'status']);
            $table->index('transaction_id');
            //connection
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
