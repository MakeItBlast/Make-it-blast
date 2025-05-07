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
        Schema::create('blast_questions', function (Blueprint $table) {
            $table->id(); 
            $table->text('question'); // Stores the question text
            $table->unsignedBigInteger('blast_id'); // Foreign key reference to blasts table
            $table->enum('status',['active','inactive'])->default('active'); // Active/Inactive Status
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // Adds deleted_at for soft delete

            // Foreign Key Constraint
            $table->foreign('blast_id')->references('id')->on('blasts')->onDelete('cascade');
            // Unique constraint on blast_id
            $table->unique('blast_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blast_questions');
    }
};
