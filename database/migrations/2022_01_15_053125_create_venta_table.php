<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->id( 'idventa' );

            $table->bigInteger('fkidcliente')->unsigned();
            $table->text('nota')->nullable();
            $table->float('montototal')->default(0);

            $table->text('nombre');
            $table->text('apellido');
            $table->string('nit');
            $table->string('tipopago');

            $table->text('telefono');
            $table->text('email');

            $table->text('ciudad')->nullable();
            $table->text('direccion')->nullable();

            $table->bigInteger("x_idusuario")->unsigned()->nullable();

            $table->date("x_fecha");
            $table->time("x_hora");
            $table->enum("isdelete", ["A", "N"])->default("A");
            $table->enum("estado", ["A", "N"])->default("A");

            $table->timestamps();
            $table->softDeletes();

            $table->foreign( 'fkidcliente' )->references( 'idcliente' )->on( 'cliente' );

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venta');
    }
}
