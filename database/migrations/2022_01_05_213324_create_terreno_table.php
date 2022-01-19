<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerrenoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terreno', function (Blueprint $table) {
            $table->id('idterreno');

            $table->string('descripcion', 150);
            $table->string('ciudad', 300);
            $table->string('direccion', 400);

            $table->text('latitud')->nullable();
            $table->text('longitud')->nullable();

            $table->longText('imagen')->nullable();
            
            $table->text('nota')->nullable();
            $table->float('precio')->default(0);

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
        Schema::dropIfExists('terreno');
    }
}
