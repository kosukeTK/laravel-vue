<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->smallInteger('year');
            $table->smallInteger('month');
            $table->smallInteger('day');
            $table->bigInteger('user_id');
            $table->bigInteger('album_no');
            $table->string('address', 50);
            $table->string('title', 50);
            $table->string('comment', 100)->nullable();
            $table->boolean('sakujo_flg')->default(false);
            $table->timestamps();

            $table->primary(['year', 'month', 'day', 'user_id', 'album_no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albums');
    }
}
