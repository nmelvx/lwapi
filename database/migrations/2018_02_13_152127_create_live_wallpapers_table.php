<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiveWallpapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_wallpapers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('typeID')->index('typeID');
            $table->integer('categID')->index('categID');
            $table->integer('userID')->index('userID');
            $table->string('previewURL')->nullable();
            $table->string('resourceURL')->nullable();
            $table->string('title');
            $table->enum('statusID', array('active', 'inactive'));
            $table->integer('ratingUp')->default(0);
            $table->integer('ratingDown')->default(0);
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
        Schema::dropIfExists('live_wallpapers');
    }
}
