<?php

namespace Database\Seeders;

use App\Models\Venta\Cliente;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ( $this->get_data() as $data ) {
            Cliente::create( $data );
        }
    }

    public function get_data() {
        $mytime = new Carbon("America/La_Paz");
        return [
            [
                "nombre" => "Eduardo",
                "apellido" => "Ferreira Loayza",
                "telefono" => "65236589",
                "nit" => "456325698652",
                "email" => "eduardo@gmail.com",

                "x_idusuario" => null,

                "x_fecha" => $mytime->toDateString(),
                "x_hora"  => $mytime->toTimeString(),
            ],
            [
                "nombre" => "Francisca",
                "apellido" => "Arancibia Alvares",
                "telefono" => "78965263",
                "nit" => "75369235632",
                "email" => "francisca@gmail.com",
                
                "x_idusuario" => null,

                "x_fecha" => $mytime->toDateString(),
                "x_hora"  => $mytime->toTimeString(),
            ],
            [
                "nombre" => "Fabricio",
                "apellido" => "PArada Alvares",
                "telefono" => "78965263",
                "nit" => "75369235632",
                "email" => "fabricio@gmail.com",
                
                "x_idusuario" => null,

                "x_fecha" => $mytime->toDateString(),
                "x_hora"  => $mytime->toTimeString(),
            ],
            [
                "nombre" => "Carla Lorena",
                "apellido" => "Condori Mendes",
                "telefono" => "78965263",
                "nit" => "75369235632",
                "email" => "carla@gmail.com",
                
                "x_idusuario" => null,

                "x_fecha" => $mytime->toDateString(),
                "x_hora"  => $mytime->toTimeString(),
            ],
        ];
    }
}
