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
            $table->string('name')->nullable();
            $table->integer('typeID')->index('typeID');
            $table->integer('categID')->index('categID');
            $table->string('previewURL')->nullable();
            $table->string('resourcesURL')->nullable();
            $table->string('title');
            $table->integer('statusID')->index('statusID');
            $table->integer('ratingUp');
            $table->integer('ratingDown');
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
