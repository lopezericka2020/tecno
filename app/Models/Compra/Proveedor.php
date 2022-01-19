<?php

namespace App\Models\Compra;

use App\Models\Functions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'proveedor';
    protected $primaryKey = 'idproveedor';

    public $timestamps = true;

    protected $dates = [
        "created_at", "updated_at", "deleted_at",
    ];

    protected $attributes = [
        "x_idusuario" => null,
        "isdelete" => "A", "estado" => "A",
    ];

    protected $fillable = [
        "nombre", "apellido", "telefono", "nit", "email", "razonsocial", "tipopersoneria",
        "x_idusuario", "x_fecha", "x_hora", "isdelete", "estado",
    ];

    public function get_data( $query, $request ) {

        $search = isset( $request->search ) ? $request->search : null;
        $order = isset( $request->order ) ? $request->order : "ASC";
        $column = isset( $request->column ) ? $request->column : "idproveedor";

        $functions = new Functions();

        if ( strtoupper( $order ) !== "DESC" ) $order = "ASC";

        $proveedor = $query
            ->select( [
                'idproveedor', 'nombre', 'apellido', 'telefono', 'nit', 'email', 'razonsocial', 'tipopersoneria',
                'estado', 'isdelete', 'x_fecha', 'x_hora',
            ] )
            ->where( function ( $query ) use ( $search, $functions ) {
                if ( !is_null( $search ) ) {
                    return $query->where( 'nombre', $functions->isLikeOrIlike(), "%" . $search . "%" );
                }
                return;
            } )
            ->orderBy( $column, $order )
            ->get();

        return $proveedor;
    }

    public function get_paginate( $query, $request ) {

        $search    = isset( $request->search ) ? $request->search : null;
        $order     = isset( $request->order ) ? $request->order : "ASC";
        $column    = isset( $request->column ) ? $request->column : "idproveedor";
        $paginate  = isset( $request->search ) ? $request->search : 10;

        $functions = new Functions();

        if ( strtoupper( $order ) !== "DESC" ) $order = "ASC";
        if ( !is_numeric( $paginate ) ) $paginate = 10;

        $proveedor = $query
            ->select( [
                'idproveedor', 'nombre', 'apellido', 'telefono', 'nit', 'email', 'razonsocial', 'tipopersoneria',
                'estado', 'isdelete', 'x_fecha', 'x_hora',
            ] )
            ->where( function ( $query ) use ( $search, $functions ) {
                if ( !is_null( $search ) ) {
                    return $query->where( 'nombre', $functions->isLikeOrIlike(), "%" . $search . "%" );
                }
                return;
            } )
            ->orderBy( $column, $order )
            ->paginate($paginate);

        return $proveedor;
    }

    public function guardar( $query, $request ) 
    {
        $nombre  = isset( $request->nombre ) ? $request->nombre : null;
        $apellido = isset( $request->apellido ) ? $request->apellido : null;
        $telefono = isset( $request->telefono ) ? $request->telefono : null;
        $nit = isset( $request->nit ) ? $request->nit : null;
        $email = isset( $request->email ) ? $request->email : null;
        $razonsocial = isset( $request->razonsocial ) ? $request->razonsocial : null;
        $tipopersoneria = isset( $request->tipopersoneria ) ? $request->tipopersoneria : null;

        $x_idusuario  = isset( $request->x_idusuario ) ? $request->x_idusuario : null;
        $x_fecha      = isset( $request->x_fecha ) ? $request->x_fecha : null;
        $x_hora       = isset( $request->x_hora ) ? $request->x_hora : null;

        $proveedor = $query->create( [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'nit' => $nit,
            'email' => $email,
            'razonsocial' => $razonsocial,
            'tipopersoneria' => $tipopersoneria,

            'x_idusuario' => $x_idusuario,
            'x_fecha'     => $x_fecha,
            'x_hora'      => $x_hora,
        ] );

        return $proveedor;
    }

    public function actualizar( $query, $request ) 
    {
        $idproveedor = isset( $request->idproveedor ) ? $request->idproveedor : null;
        $nombre    = isset( $request->nombre ) ? $request->nombre : null;
        $apellido    = isset( $request->apellido ) ? $request->apellido : null;
        $telefono = isset( $request->telefono ) ? $request->telefono : null;
        $nit = isset( $request->nit ) ? $request->nit : null;
        $email = isset( $request->email ) ? $request->email : null;
        $razonsocial = isset( $request->razonsocial ) ? $request->razonsocial : null;
        $tipopersoneria = isset( $request->tipopersoneria ) ? $request->tipopersoneria : null;

        $proveedor = $query->where( 'idproveedor', '=', $idproveedor )
            ->update( [
                'nombre' => $nombre,
                'apellido' => $apellido,
                'telefono' => $telefono,
                'nit' => $nit,
                'email' => $email,
                'razonsocial' => $razonsocial,
                'tipopersoneria' => $tipopersoneria,
            ] );

        return $proveedor;
    }

    public function detalle( $query, $idproveedor )
    {

        $proveedor = $query
            ->select( [
                'idproveedor', 'nombre', 'apellido', 'telefono', 'nit', 'email', 'razonsocial', 'tipopersoneria',
                'estado', 'isdelete', 'x_fecha', 'x_hora',
            ] )
            ->where( 'idproveedor', '=', $idproveedor )
            ->orderBy( 'idproveedor', 'ASC' )
            ->first();

        return $proveedor;
    }

}
