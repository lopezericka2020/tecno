<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerrenoserviciodetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terrenoserviciodetalle', function (Blueprint $table) {
            $table->id( 'idterrenoserviciodetalle' );
            
            $table->bigInteger('fkidterreno')->unsigned();
            $table->bigInteger('fkidservicio')->unsigned();
            $table->bigInteger("x_idusuario")->unsigned()->nullable();

            $table->date("x_fecha");
            $table->time("x_hora");
            $table->enum("isdelete", ["A", "N"])->default("A");
            $table->enum("estado", ["A", "N"])->default("A");

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fkidterreno')->references('idterreno')->on('terreno');
            $table->foreign('fkidservicio')->references('idservicio')->on('servicio');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terrenoserviciodetalle');
    }
}
