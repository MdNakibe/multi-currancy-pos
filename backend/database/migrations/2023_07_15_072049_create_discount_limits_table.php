<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emp_id')->nullable()->constrained('employees');
            $table->foreignId('approve_by')->nullable()->constrained('users');
            $table->double('requested_amount', 18,2)->default(0);
            $table->tinyInteger('status')->default(0)->comment('0 => requested, 1 => approved, 2 => rejected');
            $table->dateTime('request_time')->useCurrent();
            $table->dateTime('approve_time')->nullable();
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
        Schema::dropIfExists('discount_limits');
    }
}
