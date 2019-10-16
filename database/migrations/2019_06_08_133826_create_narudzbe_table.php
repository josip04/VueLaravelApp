<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNarudzbeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('narudzbe', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('narudzba');
            $table->integer('iznos');
            $table->string('user_email');
            $table->string('adresa');
            $table->integer('kontakt');
            $table->string('status');//naknadno dodano
            $table->bigInteger('restoran_id')->unsigned();
            $table->foreign('restoran_id')->references('id')->on('restorani')->onDelete('cascade');
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
        Schema::dropIfExists('narudžbe');
        Schema::dropForeign('restoran_id');
    }
}
