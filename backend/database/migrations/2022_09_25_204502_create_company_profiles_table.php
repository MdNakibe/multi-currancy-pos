<?php

use App\Models\CompanyProfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 190)->nullable();
            $table->text('address', 255)->nullable();
            $table->string('contact_us', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('image', 100)->nullable();
            $table->string('type', 1)->nullable();
            $table->decimal('point', 18,2)->default(0);
            $table->decimal('rate', 18,2)->default(0);
            $table->decimal('dolor_rate')->default(1);
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
        // CompanyProfile::create([
        //     'company_name' => 'ERP',
        //     'address' => 'Dhaka',
        //     'contact_us' => '5546546222',
        //     'email' => 'demo@example.com',
        //     'type' => 1,
        // ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_profiles');
    }
}
