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
            $table->string('email');
            $table->string('remember_token');
            $table->string('change_password_token');
            $table->string('change_password_token_tmp');
            $table->timestamp('change_password_token_created');
            $table->string('reset_password_token');
            $table->string('reset_password_token_tmp');
            $table->timestamp('reset_password_token_created');
            $table->string('signup_token');
            $table->timestamp('signup_token_created');
            $table->string('password');
            $table->string('permissions');
            $table->timestamp('last_login');    
            $table->string('fingerprint');
            $table->integer('login_failed');
            $table->integer('role_id');
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
