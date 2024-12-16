<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskCheckListCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_check_list_comments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('taskCheckListId')->nullable(); // Foreign key to taskCheckList table
            $table->text('commentValue')->nullable(); // Comment text
            $table->unsignedBigInteger('created_by')->nullable(); // User who created the comment
         
            $table->boolean('isactive')->default(1); // Active status
            $table->boolean('isdelete')->default(0); // Deletion status
            $table->unsignedBigInteger('modified_by')->nullable(); // ID of user who modified the comment
    
            $table->timestamps(); // Laravel's created_at and updated_at columns

            // Optional: Add a foreign key constraint for taskCheckListId
            $table->foreign('taskCheckListId')->references('id')->on('task_check_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_check_list_comments');
    }
}