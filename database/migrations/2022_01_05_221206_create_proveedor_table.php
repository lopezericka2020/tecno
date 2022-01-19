<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor', function (Blueprint $table) {
            $table->id('idproveedor');

            $table->string('nombre', 150);
            $table->string('apellido', 250);

            $table->string('razonsocial', 350);
            $table->enum("tipopersoneria", ["N", "J"])->default("N");

            $table->string('telefono', 100);
            $table->string('nit', 50);
            $table->string('email', 350);

            $table->bigInteger("x_idusuario")->unsigned()->nullable();

            $table->date("x_fecha");
            $table->time("x_hora");
            $table->enum("isdelete", ["A", "N"])->default("A");
            $table->enum("estado", ["A", "N"])->default("A");

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedor');
    }
}
