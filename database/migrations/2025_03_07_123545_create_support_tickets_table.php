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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // String column for the title
            $table->text('message'); // Text column for the message
            $table->string('ticket_id'); // String column for the title
            $table->enum('priority', ['low', 'medium','high']); // Enum column for the status
            $table->string('supporting_image')->nullable(); // String column for the supporting image (nullable)
            $table->enum('status', ['open', 'closed'])->default('open'); // Enum column for the status
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('user_id'); 
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_tickets');
    }
};
