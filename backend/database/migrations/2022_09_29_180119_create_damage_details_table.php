<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damage_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('damage_id')->constrained('damages');
            $table->foreignId('product_id')->constrained('products');
            $table->float('quantity', 18,2)->default(0.00);
            $table->decimal('rate', 18,2)->default(0.00);
            $table->decimal('total', 18,2)->default(0.00);
            $table->string('status', 1)->default('a')->comment('a => active, d => deactive');
            $table->foreignId('added_by')->nullable()->constrained('users');
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
        Schema::dropIfExists('damage_details');
    }
}
