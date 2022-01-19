<?php

namespace Database\Seeders;

use App\Models\Venta\Servicio;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ( $this->get_data() as $data ) {
            Servicio::create( $data );
        }
    }

    public function get_data() {
        $mytime = new Carbon("America/La_Paz");
        return [
            [
                "descripcion" => "Agua Potable",
                "x_idusuario" => null,

                "x_fecha" => $mytime->toDateString(),
                "x_hora"  => $mytime->toTimeString(),
            ],
            [
                "descripcion" => "Luz Electrica",
                "x_idusuario" => null,

                "x_fecha" => $mytime->toDateString(),
                "x_hora"  => $mytime->toTimeString(),
            ],
            [
                "descripcion" => "Gas Domiciliario",
                "x_idusuario" => null,

                "x_fecha" => $mytime->toDateString(),
                "x_hora"  => $mytime->toTimeString(),
            ],
        ];
    }
}
