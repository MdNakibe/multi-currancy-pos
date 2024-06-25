<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->nullable()->constrained('purchases');
            $table->foreignId('product_id')->constrained('products');
            $table->float('quantity', 18,2)->default(0.00);
            $table->decimal('purchase_rate_usd', 18,2)->default(0.00);
            $table->decimal('purchase_rate_srd', 18,2)->default(0.00);
            $table->decimal('sale_rate', 18,2)->default(0.00);
            $table->decimal('total_usd', 18,2)->default(0.00);
            $table->decimal('total_srd', 18,2)->default(0.00);
            $table->decimal('discount', 18,2)->default(0.00);
            $table->unsignedDecimal('exchange_rate')->default(1);
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
        Schema::dropIfExists('purchase_details');
    }
}
