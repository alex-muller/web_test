<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_views', function (Blueprint $table) {
            $table->increments('id');
            $table->string('profile_id');
            $table->unsignedInteger('city_id');
            $table->integer('count');

            $table->foreign('profile_id')
                ->references('profile_id')->on('profiles')
                ->onDelete('CASCADE');

            $table->foreign('city_id')
                ->references('id')->on('cities')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_views');
    }
}
