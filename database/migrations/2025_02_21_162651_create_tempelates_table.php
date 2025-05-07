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
        Schema::create('tempelates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign Key to users table
            $table->string('temp_name'); // Varchar column for template name
            $table->text('template_structure'); // Stores template data
            $table->enum('template_by', ['admin', 'user']); // Enum for admin or user
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // Adds deleted_at for soft delete

            // Foreign Key Constraint
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
        Schema::dropIfExists('tempelates');
    }
};
