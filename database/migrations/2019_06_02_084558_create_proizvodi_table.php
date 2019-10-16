<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProizvodiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proizvodi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('proizvod_naziv');
            $table->bigInteger('kategorija_id')->unsigned();
            $table->foreign('kategorija_id')->references('id')->on('kategorije')->onDelete('cascade');
            $table->integer('cijena');
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
        Schema::dropIfExists('proizvodi');
        Schema::dropForeign('kategorija_id');//dodatno nakon migracije
    }
}
