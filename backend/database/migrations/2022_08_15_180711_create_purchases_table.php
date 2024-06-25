<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('invoice', 40);
            $table->date('date');
            $table->string('po_no')->nullable();
            $table->date('po_date')->nullable();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('employee_id');
            $table->decimal('total', 18,2)->default(0.00);
            $table->decimal('sub_total', 18,2)->default(0.00);
            $table->decimal('discount', 18,2)->default(0.00);
            $table->decimal('transport', 18,2)->default(0.00);
            $table->decimal('vat', 18,2)->default(0.00);
            $table->decimal('paid', 18,2)->default(0.00);
            $table->decimal('due', 18,2)->default(0.00);
            $table->decimal('previous_due', 18,2)->default(0.00);
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
        Schema::dropIfExists('purchases');
    }
}
