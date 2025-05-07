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
    Schema::create('contact_types', function (Blueprint $table) {
        $table->id(); // Primary key for contact types
        $table->string('contact_type'); // Column for the type of contact (e.g., 'email', 'phone')
        
        // Foreign key to the users table
        $table->unsignedBigInteger('user_id')->nullable(); // Make nullable if needed

        $table->text('contact_desc')->nullable();;
        $table->enum('status',['active','inactive']);

        // Foreign Key Constraints
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
        $table->softDeletes(); // Soft delete functionality
        $table->timestamps(); // created_at and updated_at columns
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_types');
    }
};
