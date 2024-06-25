<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceIdCurrentInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('current_inventories', function (Blueprint $table) {
            $table->foreignId('price_id')->nullable()->constrained('prices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('current_inventories', function (Blueprint $table)
        {
            if(Schema::hasColumn('current_inventories', 'price_id')){
                $table->dropConstrainedForeignId('price_id');
            }
        });
    }
}
