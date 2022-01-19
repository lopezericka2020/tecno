<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlandepagodetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plandepagodetalle', function (Blueprint $table) {
            $table->id( 'idplandepagodetalle' );
            
            $table->bigInteger('fkidplandepago')->unsigned();
            $table->bigInteger('fkidventa')->unsigned();

            $table->float('montoapagar');
            $table->string('nrocuota');
            $table->string('fechaapagar');

            $table->bigInteger("x_idusuario")->unsigned()->nullable();

            $table->date("x_fecha");
            $table->time("x_hora");
            $table->enum("isdelete", ["A", "N"])->default("A");
            $table->enum("estado", ["A", "N"])->default("A");
            $table->enum("estadoproceso", ["A", "N"])->default("A");

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fkidplandepago')->references('idplandepago')->on('plandepago');
            $table->foreign('fkidventa')->references('idventa')->on('venta');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plandepagodetalle');
    }
}
