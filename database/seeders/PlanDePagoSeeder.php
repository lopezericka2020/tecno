<?php

namespace Database\Seeders;

use App\Models\Venta\PlanDePago;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PlanDePagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ( $this->get_data() as $data ) {
            PlanDePago::create( $data );
        }
    }

    public function get_data() {
        $mytime = new Carbon("America/La_Paz");
        return [
            [
                "fkidterreno" => 1,
                "anticipo" => 2000,
                "nrocuota" => 50,
                "tipopago" => "Mensual",

                "x_idusuario" => null,

                "x_fecha" => $mytime->toDateString(),
                "x_hora"  => $mytime->toTimeString(),
            ],
            [
                "fkidterreno" => 2,
                "anticipo" => 1500,
                "nrocuota" => 50,
                "tipopago" => "Mensual",

                "x_idusuario" => null,

                "x_fecha" => $mytime->toDateString(),
                "x_hora"  => $mytime->toTimeString(),
            ],
        ];
    }
}
