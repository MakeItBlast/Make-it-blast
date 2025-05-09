<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('blast_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); 
            $table->string('blast_invoice_num');
            $table->unsignedBigInteger('blast_id'); 
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('blast_id')->references('id')->on('blasts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('blast_invoices');
    }
};
