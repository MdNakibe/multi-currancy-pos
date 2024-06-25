<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->float('purchase_quantity', 10, 2)->default(0);
            $table->float('purchase_return', 10, 2)->default(0);
            $table->float('sale_quantity', 10, 2)->default(0);
            $table->float('sale_return', 10, 2)->default(0);
            $table->float('transfer_from_quantity', 10, 2)->default(0);
            $table->float('transfer_to_quantity', 10, 2)->default(0);
            $table->float('damage_quantity', 10, 2)->default(0);
            $table->foreignId('branch_id')->nullable()->constrained('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('current_inventories');
    }
}
