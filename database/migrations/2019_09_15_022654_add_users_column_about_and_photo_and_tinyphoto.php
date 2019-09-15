<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersColumnAboutAndPhotoAndTinyphoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('about')->after('email');
            $table->string('nickname')->after('name');
            $table->string('main_photo')->after('about');
            $table->string('tiny_photo')->after('main_photo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('about');
            $table->dropColumn('nickname');
            $table->dropColumn('main_photo');
            $table->dropColumn('tiny_photo');
        });
    }
}
