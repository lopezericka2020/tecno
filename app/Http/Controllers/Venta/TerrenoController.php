<?php

namespace App\Http\Controllers\Venta;

use App\Http\Controllers\Controller;
use App\Models\Venta\PlanDePago;
use App\Models\Venta\Servicio;
use App\Models\Venta\Terreno;
use App\Models\Venta\TerrenoServicioDetalle;
use App\Models\Venta\VentaDetalle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TerrenoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        try {
            
            $terrno = new Terreno();
            $arrayterreno = $terrno->get_data( $terrno, $request );
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "arrayTerreno" => $arrayterreno,
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

            $serv = new Servicio();
            $arrayservicio = $serv->get_data( $serv, $request );
            
            return response()->json( [
                "rpta" => 1,
                "arrayservicio" => $arrayservicio,
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
                'ciudad' => "required|max:300",
                'direccion' => "required|max:400",

                'precio' => "required|numeric",

                'x_idusuario' => "nullable|numeric",
                'x_fecha' => "required|date",
                'x_hora' => "required|date_format:H:i:s",
            ];

            $messages = [
                "descripcion.required" => "Campo requerido",
                "descripcion.max" => "Se permite máximo 150 caracteres",

                "ciudad.required" => "Campo requerido",
                "ciudad.max" => "Se permite máximo 300 caracteres",

                "direccion.required" => "Campo requerido",
                "direccion.max" => "Se permite máximo 400 caracteres",

                "precio.required" => "Campo requerido",
                "precio.numeric" => "Campo permite tipo número",

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

            $terrno = new Terreno();
            $terreno = $terrno->guardar( $terrno, $request );

            if ( $request->habilitarplandepago === "A" ) {
                $plandepago = new PlanDePago();
                $plandepago->fkidterreno = $terreno->idterreno;
                $plandepago->anticipo = $request->anticipo;
                $plandepago->nrocuota = $request->nrocuota;
                $plandepago->tipopago = $request->tipopago;
                $plandepago->x_fecha = $request->x_fecha;
                $plandepago->x_hora = $request->x_hora;
                $plandepago->save();
            }

            $arrayServicio = isset($request->arrayFKIDServicio) ? json_decode($request->arrayFKIDServicio) : [];

            foreach ( $arrayServicio as $servicio ) {
                $terrenoservicio = new TerrenoServicioDetalle();
                $terrenoservicio->fkidterreno = $terreno->idterreno;
                $terrenoservicio->fkidservicio = $servicio->idservicio;
                $terrenoservicio->x_fecha = $request->x_fecha;
                $terrenoservicio->x_hora = $request->x_hora;
                $terrenoservicio->save();
            }
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Terreno creado exitosamente",
                "terreno" => $terreno,
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
    public function show( Request $request, $idterreno )
    {
        try {

            $terrno = new Terreno();
            $terreno = $terrno->detalle( $terrno, $idterreno );

            if ( is_null( $terreno ) ) {
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Terreno no existente",
                ] );
            }

            $terrservdet = new TerrenoServicioDetalle();
            $arrayTerrenoServicio = $terrservdet
                ->select( 'terrenoserviciodetalle.idterrenoserviciodetalle', 'serv.idservicio', 'serv.descripcion' )
                ->join( 'servicio as serv', 'terrenoserviciodetalle.fkidservicio', '=', 'serv.idservicio' )
                ->where( 'terrenoserviciodetalle.fkidterreno', '=', $idterreno )
                ->orderBy( 'terrenoserviciodetalle.idterrenoserviciodetalle' )
                ->get();

            $planpag = new PlanDePago();
            $plandepago = $planpag->where( 'fkidterreno', '=', $idterreno )->first();
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "terreno" => $terreno,
                "arrayTerrenoServicio" => $arrayTerrenoServicio,
                "plandepago" => $plandepago,
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
    public function edit( Request $request, $idterreno )
    {
        try {

            $terrno = new Terreno();
            $terreno = $terrno->detalle( $terrno, $idterreno );

            if ( is_null( $terreno ) ) {
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Terreno no existente",
                ] );
            }

            $serv = new Servicio();
            $arrayservicio = $serv->get_data( $serv, $request );

            $terrservdet = new TerrenoServicioDetalle();
            $arrayTerrenoServicio = $terrservdet
                ->select( 'terrenoserviciodetalle.idterrenoserviciodetalle', 'serv.idservicio', 'serv.descripcion' )
                ->join( 'servicio as serv', 'terrenoserviciodetalle.fkidservicio', '=', 'serv.idservicio' )
                ->where( 'terrenoserviciodetalle.fkidterreno', '=', $idterreno )
                ->orderBy( 'terrenoserviciodetalle.idterrenoserviciodetalle' )
                ->get();

            $planpag = new PlanDePago();
            $plandepago = $planpag->where( 'fkidterreno', '=', $idterreno )->first();
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "terreno" => $terreno,
                "arrayServicio" => $arrayservicio,
                "arrayTerrenoServicio" => $arrayTerrenoServicio,
                "plandepago" => $plandepago,
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
                'idterreno' => "required|numeric",
                'descripcion' => "required|max:150",
                'ciudad' => "required|max:300",
                'direccion' => "required|max:400",

                'precio' => "required|numeric",
            ];

            $messages = [
                "idterreno.required" => "Campo requerido",
                "idterreno.numeric" => "Campo permite tipo número",

                "descripcion.required" => "Campo requerido",
                "descripcion.max" => "Se permite máximo 150 caracteres",

                "ciudad.required" => "Campo requerido",
                "ciudad.max" => "Se permite máximo 300 caracteres",

                "direccion.required" => "Campo requerido",
                "direccion.max" => "Se permite máximo 400 caracteres",

                "precio.required" => "Campo requerido",
                "precio.numeric" => "Campo permite tipo número",
            ];

            $validator = Validator::make( $request->all(), $rules, $messages );

            if ( $validator->fails() ) {

                return response()->json( [
                    "rpta" => -1,
                    "message" => "Advertencia llenar campos requeridos",
                    "errors" => $validator->errors(),
                ] );
            }

            $terrno = new Terreno();

            if ( is_null( $terrno->find( $request->idterreno ) ) ) {
                
                return response()->json( [
                    "rpta" => 0,
                    "message" => "Terreno no existente.",
                ] );
            }
            $terreno = $terrno->actualizar( $terrno, $request );

            $arrayServicio = isset($request->arrayFKIDServicio) ? json_decode($request->arrayFKIDServicio) : [];
            $arrayDeleteServicio = isset($request->arrayDeleteFKIDServicio) ? json_decode($request->arrayDeleteFKIDServicio) : [];

            $mytime = new Carbon("America/La_Paz");

            if ( $request->habilitarplandepago === "A" ) {

                $planpag = new PlanDePago();
                $getCount = $planpag->where( 'fkidterreno', '=', $request->idterreno )->first();

                if ( is_null( $getCount ) ) {
                    $plandepago = new PlanDePago();
                    $plandepago->fkidterreno = $request->idterreno;
                    $plandepago->anticipo = $request->anticipo;
                    $plandepago->nrocuota = $request->nrocuota;
                    $plandepago->tipopago = $request->tipopago;
                    $plandepago->x_fecha = $request->x_fecha;
                    $plandepago->x_hora = $request->x_hora;
                    $plandepago->save();
                } else {
                    $plandepago = $planpag->find( $getCount->idplandepago );
                    $plandepago->anticipo = $request->anticipo;
                    $plandepago->nrocuota = $request->nrocuota;
                    $plandepago->tipopago = $request->tipopago;
                    $plandepago->update();
                }
            }

            foreach ( $arrayServicio as $servicio ) {

                if  ( is_null( $servicio->idterrenoserviciodetalle ) ) {
                    $terrenoservicio = new TerrenoServicioDetalle();
                    $terrenoservicio->fkidterreno = $request->idterreno;
                    $terrenoservicio->fkidservicio = $servicio->idservicio;
                    $terrenoservicio->x_fecha = $mytime->toDateString();
                    $terrenoservicio->x_hora = $mytime->toTimeString();
                    $terrenoservicio->save();
                }

            }

            foreach ( $arrayDeleteServicio as $servicio ) {

                if  ( !is_null( $servicio->idterrenoserviciodetalle ) ) {
                    $terrservdet = new TerrenoServicioDetalle();
                    $terrenoservicio = $terrservdet->find( $servicio->idterrenoserviciodetalle );
                    $terrenoservicio->delete();
                }
                
            }
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Terreno actualizado exitosamente",
                "terreno" => $terreno,
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
    public function destroy( $idterreno )
    {
        try {

            $terrno = new Terreno();
            $terreno = $terrno->find( $idterreno );

            if ( is_null( $terreno ) ) {
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Terreno no existente",
                ] );
            }

            if ( $terreno->isdelete == "N" ) {
                return response()->json( [
                    "rpta" => 0,
                    "message" => "Terreno no permitido eliminar.",
                ] );
            }

            $vtadet = new VentaDetalle();

            $getCount = $vtadet->where( 'fkidterreno', '=', $idterreno )->get();
            if ( sizeof( $getCount ) > 0 ) {
                return response()->json( [
                    "rpta" => 0,
                    "message" => "No se pudo eliminar ya que se encuentra en una transaccion realizada.",
                ] );
            }

            $terrenodelete = $terreno->delete();
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Terreno eliminado exitosamente",
                "terreno" => $terrenodelete,
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
