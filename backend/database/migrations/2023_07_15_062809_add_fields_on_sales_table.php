<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsOnSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->double('commission_rate', 5,2)->default(0);
            $table->double('commission_amount', 18,2)->default(0);
            $table->boolean('isSRD')->default(0);
            $table->double('currency_rate')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('commission_rate');
            $table->dropColumn('commission_amount');
            $table->dropColumn('isSRD');
            $table->dropColumn('currency_rate');
        });
    }
}
