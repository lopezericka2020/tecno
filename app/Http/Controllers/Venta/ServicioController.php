<?php

namespace App\Http\Controllers\Venta;

use App\Http\Controllers\Controller;
use App\Models\Venta\Servicio;
use App\Models\Venta\TerrenoServicioDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        try {
            
            $serv = new Servicio();
            $arrayservicio = $serv->get_data( $serv, $request );
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "arrayservicio" => $arrayservicio,
            ] );

        } catch (\Throwable $th) {
            return response()->json( [
                'rpta' => -5,
                "message" => "Error al realizar servicio",
                "errors" => [
                    "file" => $th->getFile(),
                    "line" => $th->getLine(),
                    "message" => $th->getMessage(),
                ],
            ] );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request )
    {
        try {
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
            ] );

        } catch (\Throwable $th) {
            return response()->json( [
                'rpta' => -5,
                "message" => "Error al realizar servicio",
                "errors" => [
                    "file" => $th->getFile(),
                    "line" => $th->getLine(),
                    "message" => $th->getMessage(),
                ],
            ] );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        try {

            $rules = [
                'descripcion' => "required|max:150",

                'x_idusuario' => "nullable|numeric",
                'x_fecha' => "required|date",
                'x_hora' => "required|date_format:H:i:s",
            ];

            $messages = [
                "descripcion.required" => "Campo requerido",
                "descripcion.max" => "Se permite máximo 150 caracteres",

                "x_idusuario.numeric" => "Campo permite tipo número",

                "x_fecha.required" => "Campo requerido",
                "x_fecha.date" => "Campo permite tipo fecha",

                "x_hora.required" => "Campo requerido",
                "x_hora.date_format" => "Campo permite tipo hora",
            ];

            $validator = Validator::make( $request->all(), $rules, $messages );

            if ( $validator->fails() ) {

                return response()->json( [
                    "rpta" => -1,
                    "message" => "Advertencia llenar campos requeridos",
                    "errors" => $validator->errors(),
                ] );
            }

            $serv = new Servicio();
            $servicio = $serv->guardar( $serv, $request );
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio creado exitosamente",
                "servicio" => $servicio,
            ] );

        } catch (\Throwable $th) {
            return response()->json( [
                'rpta' => -5,
                "message" => "Error al realizar servicio",
                "errors" => [
                    "file" => $th->getFile(),
                    "line" => $th->getLine(),
                    "message" => $th->getMessage(),
                ],
            ] );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, $idservicio )
    {
        try {

            $serv = new Servicio();
            $servicio = $serv->detalle( $serv, $idservicio );

            if ( is_null( $servicio ) ) {
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Servicio no existente",
                ] );
            }
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "servicio" => $servicio,
            ] );

        } catch (\Throwable $th) {
            return response()->json( [
                'rpta' => -5,
                "message" => "Error al realizar servicio",
                "errors" => [
                    "file" => $th->getFile(),
                    "line" => $th->getLine(),
                    "message" => $th->getMessage(),
                ],
            ] );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( Request $request, $idservicio )
    {
        try {

            $serv = new Servicio();
            $servicio = $serv->detalle( $serv, $idservicio );

            if ( is_null( $servicio ) ) {
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Servicio no existente",
                ] );
            }
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "servicio" => $servicio,
            ] );

        } catch (\Throwable $th) {
            return response()->json( [
                'rpta' => -5,
                "message" => "Error al realizar servicio",
                "errors" => [
                    "file" => $th->getFile(),
                    "line" => $th->getLine(),
                    "message" => $th->getMessage(),
                ],
            ] );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request )
    {
        try {

            $rules = [
                'idservicio' => "required|numeric",
                'descripcion' => "required|max:150",
            ];

            $messages = [
                "idservicio.required" => "Campo requerido",
                "idservicio.numeric" => "Campo permite tipo número",

                "descripcion.required" => "Campo requerido",
                "descripcion.max" => "Se permite máximo 150 caracteres",
            ];

            $validator = Validator::make( $request->all(), $rules, $messages );

            if ( $validator->fails() ) {

                return response()->json( [
                    "rpta" => -1,
                    "message" => "Advertencia llenar campos requeridos",
                    "errors" => $validator->errors(),
                ] );
            }

            $serv = new Servicio();

            if ( is_null( $serv->find( $request->idservicio ) ) ) {
                
                return response()->json( [
                    "rpta" => 0,
                    "message" => "Servicio no existente.",
                ] );
            }
            $servicio = $serv->actualizar( $serv, $request );
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio actualizado exitosamente",
                "servicio" => $servicio,
            ] );

        } catch (\Throwable $th) {
            return response()->json( [
                'rpta' => -5,
                "message" => "Error al realizar servicio",
                "errors" => [
                    "file" => $th->getFile(),
                    "line" => $th->getLine(),
                    "message" => $th->getMessage(),
                ],
            ] );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $idservicio )
    {
        try {

            $serv = new Servicio();
            $servicio = $serv->find( $idservicio );

            if ( is_null( $servicio ) ) {
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Servicio no existente",
                ] );
            }

            if ( $servicio->isdelete == "N" ) {
                return response()->json( [
                    "rpta" => 0,
                    "message" => "Servicio no permitido eliminar.",
                ] );
            }

            $terrnoservdet = new TerrenoServicioDetalle();
            
            $getCount = $terrnoservdet->where( 'fkidservicio', '=', $idservicio )->get();
            if ( sizeof( $getCount ) ) {
                return response()->json( [
                    "rpta" => 0,
                    "message" => "Servicio no permitido eliminar.",
                ] );
            }

            $serviciodelete = $servicio->delete();
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio eliminado exitosamente",
                "servicio" => $serviciodelete,
            ] );

        } catch (\Throwable $th) {
            return response()->json( [
                'rpta' => -5,
                "message" => "Error al realizar servicio",
                "errors" => [
                    "file" => $th->getFile(),
                    "line" => $th->getLine(),
                    "message" => $th->getMessage(),
                ],
            ] );
        }
    }
}
