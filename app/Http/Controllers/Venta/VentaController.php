<?php

namespace App\Http\Controllers\Venta;

use App\Http\Controllers\Controller;
use App\Models\PlanDePagoDetalle;
use App\Models\Venta\Cliente;
use App\Models\Venta\Terreno;
use App\Models\Venta\Venta;
use App\Models\Venta\VentaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        try {
            
            $vta = new Venta();
            $arrayVenta = $vta->get_data( $vta, $request );
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "arrayVenta" => $arrayVenta,
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

            $terrno = new Terreno();
            $arrayTerreno = $terrno->get_data( $terrno, $request );

            $clte = new Cliente();
            $arrayCliente = $clte->get_data( $clte, $request );
            
            return response()->json( [
                "rpta" => 1,
                "arrayTerreno" => $arrayTerreno,
                "arrayCliente" => $arrayCliente,
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
                'x_idusuario' => "nullable|numeric",
                'x_fecha' => "required|date",
                'x_hora' => "required|date_format:H:i:s",
            ];

            $messages = [
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

            $vta = new Venta();
            $venta = $vta->guardar( $vta, $request );

            $arrayTerreno = isset($request->arrayPlanDePago) ? json_decode($request->arrayFKIDTerreno) : [];
            $arrayPlanDePago = isset($request->arrayPlanDePago) ? json_decode($request->arrayPlanDePago) : [];

            foreach ( $arrayTerreno as $terreno ) {
                $ventadetalle = new VentaDetalle();
                $ventadetalle->fkidventa = $venta->idventa;
                $ventadetalle->fkidterreno = $terreno->idterreno;
                $ventadetalle->precio = $terreno->precio;
                $ventadetalle->cantidad = $terreno->cantidad;
                // $ventadetalle->nota = $terreno->nota;
                $ventadetalle->x_fecha = $request->x_fecha;
                $ventadetalle->x_hora = $request->x_hora;
                $ventadetalle->save();
            }

            foreach ($arrayPlanDePago as $planpago) {
                $planpagodetalle = new PlanDePagoDetalle();
                $planpagodetalle->fkidplandepago = $request->idplandepago;
                $planpagodetalle->fkidventa = $venta->idventa;
                $planpagodetalle->montoapagar = $planpago->monto;
                $planpagodetalle->fechaapagar = $planpago->fecha;
                $planpagodetalle->nrocuota = "Nro Cuota " . $planpago->nro;
                $planpagodetalle->x_fecha = $request->x_fecha;
                $planpagodetalle->x_hora = $request->x_hora;
                $planpagodetalle->save();
            }
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Venta creado exitosamente",
                "venta" => $venta,
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
    public function show( Request $request, $idventa )
    {
        try {

            $vta = new Venta();
            $venta = $vta->detalle( $vta, $idventa );

            if ( is_null( $venta ) ) {
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Venta no existente",
                ] );
            }

            $terrservdet = new VentaDetalle();
            $arrayVentaDetalle = $terrservdet
                ->select( 
                    'ventadetalle.idventadetalle', 'ventadetalle.precio', 'ventadetalle.cantidad', 'ventadetalle.nota',
                    'terrno.idterreno', 'terrno.descripcion', 'terrno.ciudad', 'terrno.direccion', 'terrno.imagen',
                    'pago.idplandepago', 'pago.nrocuota', 'pago.anticipo', 'pago.tipopago'
                )
                ->join( 'terreno as terrno', 'ventadetalle.fkidterreno', '=', 'terrno.idterreno' )
                ->leftJoin( 'plandepago as pago', 'terrno.idterreno', '=', 'pago.fkidterreno' )
                ->where( 'ventadetalle.fkidventa', '=', $idventa )
                ->orderBy( 'ventadetalle.idventadetalle' )
                ->get();

            $arrayPlanPago = PlanDePagoDetalle::where( 'fkidventa', '=', $idventa )->orderBy('plandepagodetalle.idplandepagodetalle')->get();
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "venta" => $venta,
                "arrayVentaDetalle" => $arrayVentaDetalle,
                "arrayPlanPago" => $arrayPlanPago,
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
    public function edit( Request $request, $idventa )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $idventa )
    {
        try {

            DB::beginTransaction();

            $vta = new Venta();
            $venta = $vta->find( $idventa );

            if ( is_null( $venta ) ) {
                DB::rollBack();
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Venta no existente",
                ] );
            }

            if ( $venta->isdelete == "N" ) {
                DB::rollBack();
                return response()->json( [
                    "rpta" => 0,
                    "message" => "Venta no permitido eliminar.",
                ] );
            }

            $ventadelete = $venta->delete();

            $vtadet = new VentaDetalle();
            $getventadetalle = $vtadet->where( 'fkidventa', '=', $idventa )->get();

            foreach ($getventadetalle as $detalle) {
                $ventadetalle = $vtadet->find( $detalle->idventadetalle );
                $ventadetalle->delete();
            }

            DB::commit();
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Venta eliminado exitosamente",
                "venta" => $ventadelete,
            ] );

        } catch (\Throwable $th) {
            DB::rollBack();
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
