<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ( $this->get_data() as $data ) {
            User::create( $data );
        }
    }

    public function get_data() {
        $mytime = new Carbon("America/La_Paz");
        return [
            [
                "nombre" => "Ericka",
                "apellido" => "Lopez Santos",
                "email" => "ericka@gmail.com",

                "fkidgrupousuario" => 1,

                "login" => "ericka",
                "password" => bcrypt( "123456" ),

                "x_idusuario" => null,

                "x_fecha" => $mytime->toDateString(),
                "x_hora"  => $mytime->toTimeString(),
                
                "isdelete" => "N",
                "estado"   => "A",
            ],
            [
                "nombre" => "Admin",
                "apellido" => "Secreto",
                "email" => "admin@gmail.com",

                "fkidgrupousuario" => 1,

                "login" => "admin",
                "password" => bcrypt( "123456" ),

                "x_idusuario" => null,

                "x_fecha" => $mytime->toDateString(),
                "x_hora"  => $mytime->toTimeString(),
                
                "isdelete" => "N",
                "estado"   => "A",
            ],
        ];
    }
}
