<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarySheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_sheets', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('month_id')->constrained('months');
            $table->foreignId('employee_id')->constrained('employees');
            $table->decimal('salary', 18,2)->default(0.00);
            $table->decimal('deduction', 18,2)->default(0.00);
            $table->decimal('commission', 18,2)->default(0.00);
            $table->decimal('advance', 18,2)->default(0.00);
            $table->decimal('others', 18,2)->default(0.00);
            $table->decimal('total', 18,2)->default(0.00);
            $table->string('status', 1)->default('a')->comment('a => active, d => deactive');
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
        Schema::dropIfExists('salary_sheets');
    }
}
