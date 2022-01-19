<?php

namespace App\Http\Controllers\Venta;

use App\Http\Controllers\Controller;
use App\Models\Venta\Cliente;
use App\Models\Venta\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        try {
            
            $clte = new Cliente();
            $arraycliente = $clte->get_data( $clte, $request );
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "arrayCliente" => $arraycliente,
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
    public function store(Request $request)
    {
        try {

            $rules = [
                'nombre' => "required|max:150",
                'apellido' => "required|max:250",
                'telefono' => "required|max:100",
                'nit' => "required|max:50",
                'email' => "required|max:350",

                'x_idusuario' => "nullable|numeric",
                'x_fecha' => "required|date",
                'x_hora' => "required|date_format:H:i:s",
            ];

            $messages = [
                "nombre.required" => "Campo requerido",
                "nombre.max" => "Se permite máximo 150 caracteres",

                "apellido.required" => "Campo requerido",
                "apellido.max" => "Se permite máximo 250 caracteres",

                "telefono.required" => "Campo requerido",
                "telefono.max" => "Se permite máximo 100 caracteres",

                "nit.required" => "Campo requerido",
                "nit.max" => "Se permite máximo 50 caracteres",

                "email.required" => "Campo requerido",
                "email.max" => "Se permite máximo 350 caracteres",

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

            $clte = new Cliente();
            $cliente = $clte->guardar( $clte, $request );
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Cliente creado exitosamente",
                "cliente" => $cliente,
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
    public function show( Request $request, $idcliente )
    {
        try {

            $clte = new Cliente();
            $cliente = $clte->detalle( $clte, $idcliente );

            if ( is_null( $cliente ) ) {
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Cliente no existente",
                ] );
            }
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "cliente" => $cliente,
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
    public function edit( Request $request, $idcliente )
    {
        try {

            $clte = new Cliente();
            $cliente = $clte->detalle( $clte, $idcliente );

            if ( is_null( $cliente ) ) {
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Cliente no existente",
                ] );
            }
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "cliente" => $cliente,
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
                'idcliente' => "required|numeric",
                'nombre' => "required|max:150",
                'apellido' => "required|max:250",
                'telefono' => "required|max:100",
                'nit' => "required|max:50",
                'email' => "required|max:350",
            ];

            $messages = [
                "idcliente.required" => "Campo requerido",
                "idcliente.numeric" => "Campo permite tipo número",

                "nombre.required" => "Campo requerido",
                "nombre.max" => "Se permite máximo 150 caracteres",

                "apellido.required" => "Campo requerido",
                "apellido.max" => "Se permite máximo 250 caracteres",

                "telefono.required" => "Campo requerido",
                "telefono.max" => "Se permite máximo 100 caracteres",

                "nit.required" => "Campo requerido",
                "nit.max" => "Se permite máximo 50 caracteres",

                "email.required" => "Campo requerido",
                "email.max" => "Se permite máximo 350 caracteres",
            ];

            $validator = Validator::make( $request->all(), $rules, $messages );

            if ( $validator->fails() ) {

                return response()->json( [
                    "rpta" => -1,
                    "message" => "Advertencia llenar campos requeridos",
                    "errors" => $validator->errors(),
                ] );
            }

            $clte = new Cliente();

            if ( is_null( $clte->find( $request->idcliente ) ) ) {
                
                return response()->json( [
                    "rpta" => 0,
                    "message" => "Cliente no existente.",
                ] );
            }
            $cliente = $clte->actualizar( $clte, $request );
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Cliente actualizado exitosamente",
                "cliente" => $cliente,
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
    public function destroy( $idcliente )
    {
        try {

            $clte = new Cliente();
            $cliente = $clte->find( $idcliente );

            if ( is_null( $cliente ) ) {
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Cliente no existente",
                ] );
            }

            if ( $cliente->isdelete == "N" ) {
                return response()->json( [
                    "rpta" => 0,
                    "message" => "Cliente no permitido eliminar.",
                ] );
            }

            $vta = new Venta();

            $getCount = $vta->where( 'fkidcliente', '=', $idcliente )->get();

            if ( sizeof( $getCount ) > 0 ) {
                return response()->json( [
                    "rpta" => 0,
                    "message" => "No se pudo eliminar ya que se encuentra en una transaccion realizada.",
                ] );
            } 

            $clientedelete = $cliente->delete();
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Cliente eliminado exitosamente",
                "cliente" => $clientedelete,
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
