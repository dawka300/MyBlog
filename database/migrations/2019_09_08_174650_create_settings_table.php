<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('about');
            $table->string('email', 100)->nullable();
            $table->string('fb', 100)->nullable();
            $table->string('twitter', 100)->nullable();
            $table->string('yt', 100)->nullable();
            $table->integer('account')->nullable();
            $table->text('donate')->nullable();
            $table->string('photo1')->nullable();
            $table->string('photo2')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
