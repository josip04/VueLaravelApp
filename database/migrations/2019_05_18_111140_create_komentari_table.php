<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKomentariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komentari', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('komentar');
            $table->integer('ocijena');
            $table->bigInteger('restoran_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('komentari',function(Blueprint $table){
            $table->foreign('restoran_id')->references('id')->on('restorani')->onDelete('cascade');
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
        Schema::dropIfExists('komentari');
        Schema::dropForeign('restoran_id');
        Schema::dropForeign('user_id');
    }
}
