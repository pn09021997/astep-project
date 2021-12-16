<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('Username')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->integer('type')->default(2);
            // 1 admin 2 user normal
            $table->string('address')->nullable();
            $table->string('verify_code')->nullable();
            $table->integer('is_verify')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
