<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); 
            $table->string('name')->nullable();
            $table->dateTime('created_date')->nullable();
             $table->unsignedBigInteger('created_by')->nullable();
            $table->boolean('highPriority')->default(0);
            $table->dateTime('Deadline')->nullable();
            $table->unsignedBigInteger('Module_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->boolean('isactive')->default(1);
            $table->boolean('isdelete')->default(0);
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('Module_id')->references('id')->on('project_modules')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
