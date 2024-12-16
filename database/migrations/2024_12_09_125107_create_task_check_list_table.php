<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskCheckListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_check_lists', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('taskId')->nullable(); // Foreign key to tasks table
            $table->string('taskValue')->nullable(); // Value of the checklist item
            $table->unsignedBigInteger('created_by')->nullable(); // User who created it
      
            $table->boolean('isactive')->default(1); // Active status
            $table->boolean('isdelete')->default(0); // Deletion status
            $table->unsignedBigInteger('modified_by')->nullable(); // Modifier user ID
       
            $table->timestamps(); //php artisan make:migration remove_column_name_from_table_name


            // Optional: Add a foreign key constraint for taskId
            $table->foreign('taskId')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        // Schema::table('task_check_lists', function (Blueprint $table) {
        //     $table->string('crated_add'); // Adjust column type and attributes as needed
        // });
        Schema::dropIfExists('task_check_lists');
    }
}