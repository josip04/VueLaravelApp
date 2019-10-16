<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestoranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {//https://laravel.com/docs/5.8/migrations#generating-migrations
        Schema::create('restorani', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('naziv');
            $table->string('opis');
            $table->integer('cijenaDst');
            $table->integer('minNar');
            $table->text('info');
            $table->string('slika_url');//naknadno dodano
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });
        //naknadno dodano u mysql
        Schema::table('restorani',function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restorani');
        Schema::dropForeign('user_id');//naknadno dodano
    }
}
