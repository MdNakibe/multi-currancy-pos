<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('username', 20);
            $table->string('user_type', 15);
            $table->string('phone', 15)->unique();
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->longText('permissions')->nullable();
            $table->boolean('status')->default(true)->comment('true => active, false => inactive');
            $table->foreignId('added_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('branch_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        // $user = new User();
        // $user->name = "ZealtechBD";
        // $user->phone = "01977749733";
        // $user->username = "admin";
        // $user->email = "info@zealtechbd.com";
        // $user->password = Hash::make('password');
        // $user->user_type = "super_admin";
        // $user->branch_id = 1;
        // $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
