<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentadetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventadetalle', function (Blueprint $table) {
            $table->id( 'idventadetalle' );
            
            $table->bigInteger('fkidventa')->unsigned();
            $table->bigInteger('fkidterreno')->unsigned();
            $table->bigInteger("x_idusuario")->unsigned()->nullable();

            $table->float('precio')->default(0);
            $table->integer('cantidad')->default(0);

            $table->text('nota')->nullable();
            

            $table->date("x_fecha");
            $table->time("x_hora");
            $table->enum("isdelete", ["A", "N"])->default("A");
            $table->enum("estado", ["A", "N"])->default("A");

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fkidventa')->references('idventa')->on('venta');
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
        Schema::dropIfExists('ventadetalle');
    }
}
