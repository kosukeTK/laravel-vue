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
            $table->Increments('id');
            $table->string('name');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('prefectures')->nullable();
            $table->string('city')->nullable();
            $table->string('photo')->nullable();
            $table->string('photo_path')->unique()->nullable();
            $table->string('photo_cover')->nullable();
            $table->string('photo_cover_path')->unique()->nullable();
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
