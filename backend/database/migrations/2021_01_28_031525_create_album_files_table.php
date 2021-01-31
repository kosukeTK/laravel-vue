<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_files', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('album_no');
            $table->string('file_path',255)->unique();
            $table->timestamps();

            $table->primary(['user_id', 'album_no']);
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_files');
    }
}
