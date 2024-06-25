<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id', 20);
            $table->string('name', 100);
            $table->string('father_name', 100)->nullable();
            $table->string('mother_name', 100)->nullable();
            $table->string('spouse_name', 100)->nullable();
            $table->string('gender', 20);
            $table->date('birth_date')->nullable();
            $table->string('nid', 20)->nullable();
            $table->string('blood_group', 10)->nullable();
            $table->string('religion', 20)->nullable();
            $table->string('nationality', 30)->nullable();
            $table->string('marital_status', 10)->nullable();
            $table->string('present_address', 500)->nullable();
            $table->string('permanent_address', 500)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->date('joining_date');
            $table->decimal('salary', 18,2)->default(0.00);
            $table->string('image', 100)->nullable();
            $table->string('signature_image', 100)->nullable();
            $table->string('nominee_name', 100)->nullable();
            $table->string('nominee_image', 100)->nullable();
            $table->string('status', 1)->default('a');
            $table->foreignId('area_id')->nullable()->constrained('areas');
            $table->foreignId('designation_id')->constrained('designations');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('added_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('branch_id')->nullable()->constrained('branches');
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
