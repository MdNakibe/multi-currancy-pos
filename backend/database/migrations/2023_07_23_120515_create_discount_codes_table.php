<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emp_id')->nullable()->constrained('employees');
            $table->foreignId('approve_by')->nullable()->constrained('users');
            $table->string('code')->nullable();
            $table->double('amount', 18,2)->default(0);
            $table->double('max_limit', 18,2)->default(0);
            $table->double('used', 18,2)->default(0);
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
        Schema::dropIfExists('discount_codes');
    }
}
