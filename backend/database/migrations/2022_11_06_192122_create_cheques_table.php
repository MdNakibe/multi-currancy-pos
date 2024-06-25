<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChequesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('bank_name', 191);
            $table->string('branch_name', 191);
            $table->string('cheque_number', 50);
            $table->decimal('cheque_amount', 18, 2)->default(0);
            $table->string('cheque_status', 20);
            $table->date('date');
            $table->date('cheque_date');
            $table->date('reminder_date');
            $table->date('submit_date');
            $table->string('note', 255)->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('cheques');
    }
}
