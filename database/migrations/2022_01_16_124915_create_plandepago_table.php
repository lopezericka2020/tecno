<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlandepagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plandepago', function (Blueprint $table) {
            $table->id( 'idplandepago' );

            $table->bigInteger('fkidterreno')->unsigned();

            $table->float('anticipo')->default(0);
            $table->integer('nrocuota')->default(0);
            $table->string( 'tipopago' );

            $table->bigInteger("x_idusuario")->unsigned()->nullable();

            $table->date("x_fecha");
            $table->time("x_hora");
            $table->enum("isdelete", ["A", "N"])->default("A");
            $table->enum("estado", ["A", "N"])->default("A");

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('fkidterreno')->references('idterreno')->on('terreno');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plandepago');
    }
}
