<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20);
            $table->string('name', 150)->nullable();
            $table->string('phone', 11)->nullable();
            $table->string('email', 100)->nullable();
            $table->foreignId('area_id')->nullable()->constrained('areas');
            $table->string('address', 150)->nullable();
            $table->string('org_name', 150)->nullable();
            $table->string('type', 15);
            $table->string('org_phone', 11)->nullable();
            $table->decimal('credit_limit', 18,2)->default(0.00);
            $table->decimal('opening_balance', 18,2)->default(0.00);
            $table->foreignId('added_by')->nullable()->constrained('users');
            $table->foreignId('customer_category_id')->nullable()->constrained('customer_categories');
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
        Schema::dropIfExists('customers');
    }
}
