<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('remember_token')->nullable();
            $table->string('change_password_token')->nullable();
            $table->string('change_password_token_tmp')->nullable();
            $table->timestamp('change_password_token_created')->nullable();
            $table->string('reset_password_token')->nullable();
            $table->string('reset_password_token_tmp')->nullable();
            $table->timestamp('reset_password_token_created')->nullable();
            $table->string('signup_token')->nullable();
            $table->timestamp('signup_token_created')->nullable();
            $table->string('password')->nullable();
            $table->string('permissions')->nullable();
            $table->timestamp('last_login')->nullable();    
            $table->string('fingerprint')->nullable();
            $table->integer('login_failed')->nullable();
            $table->integer('role_id')->nullable();
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
        Schema::dropIfExists('admins');
    }
}
