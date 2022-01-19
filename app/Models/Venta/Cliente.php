<?php

namespace App\Models\Venta;

use App\Models\Functions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cliente';
    protected $primaryKey = 'idcliente';

    public $timestamps = true;

    protected $dates = [
        "created_at", "updated_at", "deleted_at",
    ];

    protected $attributes = [
        "x_idusuario" => null,
        "isdelete" => "A", "estado" => "A",
    ];

    protected $fillable = [
        "nombre", "apellido", "telefono", "nit", "email",
        "x_idusuario", "x_fecha", "x_hora", "isdelete", "estado",
    ];

    public function get_data( $query, $request ) {

        $search = isset( $request->search ) ? $request->search : null;
        $order = isset( $request->order ) ? $request->order : "ASC";
        $column = isset( $request->column ) ? $request->column : "idcliente";

        $functions = new Functions();

        if ( strtoupper( $order ) !== "DESC" ) $order = "ASC";

        $cliente = $query
            ->select( [
                'idcliente', 'nombre', 'apellido', 'telefono', 'nit', 'email',
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

        return $cliente;
    }

    public function get_paginate( $query, $request ) {

        $search    = isset( $request->search ) ? $request->search : null;
        $order     = isset( $request->order ) ? $request->order : "ASC";
        $column    = isset( $request->column ) ? $request->column : "idcliente";
        $paginate  = isset( $request->search ) ? $request->search : 10;

        $functions = new Functions();

        if ( strtoupper( $order ) !== "DESC" ) $order = "ASC";
        if ( !is_numeric( $paginate ) ) $paginate = 10;

        $cliente = $query
            ->select( [
                'idcliente', 'nombre', 'apellido', 'telefono', 'nit', 'email',
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

        return $cliente;
    }

    public function guardar( $query, $request ) 
    {
        $nombre  = isset( $request->nombre ) ? $request->nombre : null;
        $apellido = isset( $request->apellido ) ? $request->apellido : null;
        $telefono = isset( $request->telefono ) ? $request->telefono : null;
        $nit = isset( $request->nit ) ? $request->nit : null;
        $email = isset( $request->email ) ? $request->email : null;

        $x_idusuario  = isset( $request->x_idusuario ) ? $request->x_idusuario : null;
        $x_fecha      = isset( $request->x_fecha ) ? $request->x_fecha : null;
        $x_hora       = isset( $request->x_hora ) ? $request->x_hora : null;

        $cliente = $query->create( [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'nit' => $nit,
            'email' => $email,

            'x_idusuario' => $x_idusuario,
            'x_fecha'     => $x_fecha,
            'x_hora'      => $x_hora,
        ] );

        return $cliente;
    }

    public function actualizar( $query, $request ) 
    {
        $idcliente = isset( $request->idcliente ) ? $request->idcliente : null;
        $nombre    = isset( $request->nombre ) ? $request->nombre : null;
        $apellido    = isset( $request->apellido ) ? $request->apellido : null;
        $telefono = isset( $request->telefono ) ? $request->telefono : null;
        $nit = isset( $request->nit ) ? $request->nit : null;
        $email = isset( $request->email ) ? $request->email : null;

        $cliente = $query->where( 'idcliente', '=', $idcliente )
            ->update( [
                'nombre' => $nombre,
                'apellido' => $apellido,
                'telefono' => $telefono,
                'nit' => $nit,
                'email' => $email,
            ] );

        return $cliente;
    }

    public function detalle( $query, $idcliente )
    {

        $cliente = $query
            ->select( [
                'idcliente', 'nombre', 'apellido', 'telefono', 'nit', 'email',
                'estado', 'isdelete', 'x_fecha', 'x_hora',
            ] )
            ->where( 'idcliente', '=', $idcliente )
            ->orderBy( 'idcliente', 'ASC' )
            ->first();

        return $cliente;
    }

}
