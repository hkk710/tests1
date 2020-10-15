<?php

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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('user_name')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('phone_code_id')->nullable();
            $table->bigInteger('phone')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->string('timezone');
            $table->date('birthday')->nullable();
            $table->string('image');
            $table->string('driver')->default('s3');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->text('google2fa_secret')->nullable();
            $table->string('password');
            $table->string('api_token', 64)->unique();
            $table->string('ref_token')->unique();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('phone_code_id')->references('id')->on('countries');
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
