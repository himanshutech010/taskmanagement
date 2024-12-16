<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskAssigneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_assignes', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('taskId')->nullable(); // Foreign key to tasks table
            $table->unsignedBigInteger('userAssigneId')->nullable(); // User assigned to the task
            $table->unsignedBigInteger('created_by')->nullable(); // User who created the assignment
      
            $table->boolean('isactive')->default(1); // Active status
            $table->boolean('isdelete')->default(0); // Deletion status
            $table->unsignedBigInteger('modified_by')->nullable(); // Modifier user ID
         
            $table->timestamps(); // Laravel's created_at and updated_at columns

            // Optional: Add foreign key constraints
            $table->foreign('taskId')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('userAssigneId')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_assignes');
    }
}