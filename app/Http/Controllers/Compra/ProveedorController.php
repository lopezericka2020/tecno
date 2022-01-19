<?php

namespace App\Http\Controllers\Compra;

use App\Http\Controllers\Controller;
use App\Models\Compra\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        try {
            
            $provdor = new Proveedor();
            $arrayproveedor = $provdor->get_data( $provdor, $request );
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "arrayProveedor" => $arrayproveedor,
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
                'nombre' => "required|max:150",
                'apellido' => "required|max:250",
                'telefono' => "required|max:100",
                'nit' => "required|max:50",
                'razonsocial' => "required|max:350",
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

                "razonsocial.required" => "Campo requerido",
                "razonsocial.max" => "Se permite máximo 350 caracteres",

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

            $provdor = new Proveedor();
            $proveedor = $provdor->guardar( $provdor, $request );
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Proveedor creado exitosamente",
                "proveedor" => $proveedor,
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
    public function show( Request $request, $idproveedor )
    {
        try {

            $provdor = new Proveedor();
            $proveedor = $provdor->detalle( $provdor, $idproveedor );

            if ( is_null( $proveedor ) ) {
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Proveedor no existente",
                ] );
            }
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "proveedor" => $proveedor,
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
    public function edit( Request $request, $idproveedor )
    {
        try {

            $provdor = new Proveedor();
            $proveedor = $provdor->detalle( $provdor, $idproveedor );

            if ( is_null( $proveedor ) ) {
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Proveedor no existente",
                ] );
            }
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Servicio realizado exitosamente",
                "proveedor" => $proveedor,
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
                'idproveedor' => "required|numeric",
                'nombre' => "required|max:150",
                'apellido' => "required|max:250",
                'telefono' => "required|max:100",
                'nit' => "required|max:50",
                'razonsocial' => "required|max:350",
                'email' => "required|max:350",
            ];

            $messages = [
                "idproveedor.required" => "Campo requerido",
                "idproveedor.numeric" => "Campo permite tipo número",

                "nombre.required" => "Campo requerido",
                "nombre.max" => "Se permite máximo 150 caracteres",

                "apellido.required" => "Campo requerido",
                "apellido.max" => "Se permite máximo 250 caracteres",

                "telefono.required" => "Campo requerido",
                "telefono.max" => "Se permite máximo 100 caracteres",

                "nit.required" => "Campo requerido",
                "nit.max" => "Se permite máximo 50 caracteres",

                "razonsocial.required" => "Campo requerido",
                "razonsocial.max" => "Se permite máximo 350 caracteres",

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

            $provdor = new Proveedor();

            if ( is_null( $provdor->find( $request->idproveedor ) ) ) {
                
                return response()->json( [
                    "rpta" => 0,
                    "message" => "Proveedor no existente.",
                ] );
            }
            $proveedor = $provdor->actualizar( $provdor, $request );
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Proveedor actualizado exitosamente",
                "proveedor" => $proveedor,
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
    public function destroy( $idproveedor )
    {
        try {

            $provdor = new Proveedor();
            $proveedor = $provdor->find( $idproveedor );

            if ( is_null( $proveedor ) ) {
                return response()->json( [
                    "rpta" => -1,
                    "message" => "Proveedor no existente",
                ] );
            }

            if ( $proveedor->isdelete == "N" ) {
                return response()->json( [
                    "rpta" => 0,
                    "message" => "Proveedor no permitido eliminar.",
                ] );
            }

            $proveedordelete = $proveedor->delete();
            
            return response()->json( [
                "rpta" => 1,
                "message" => "Proveedor eliminado exitosamente",
                "proveedor" => $proveedordelete,
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
