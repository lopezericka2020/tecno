<?php

namespace App\Models\Venta;

use App\Models\Functions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'venta';
    protected $primaryKey = 'idventa';

    public $timestamps = true;

    protected $dates = [
        "created_at", "updated_at", "deleted_at",
    ];

    protected $attributes = [
        "nota" => null, "montototal" => 0, "ciudad" => null, "direccion" => null,
        "x_idusuario" => null,
        "isdelete" => "A", "estado" => "A",
    ];

    protected $fillable = [
        "fkidcliente", "nota", "montototal", "nombre", "apellido", "nit", "tipopago",
        "telefono", "email", "ciudad", "direccion",
        "x_idusuario", "x_fecha", "x_hora", "isdelete", "estado",
    ];

    public function get_data( $query, $request ) {

        $search = isset( $request->search ) ? $request->search : null;
        $order = isset( $request->order ) ? $request->order : "ASC";
        $column = isset( $request->column ) ? $request->column : "idventa";

        $functions = new Functions();

        if ( strtoupper( $order ) !== "DESC" ) $order = "ASC";

        $venta = $query
            ->select( [
                'idventa', 'nota', 'fkidcliente', 'montototal', 'nombre', 'apellido',
                'telefono', 'email', 'ciudad', 'direccion', 'nit', 'tipopago',
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

        return $venta;
    }

    public function get_paginate( $query, $request ) {

        $search    = isset( $request->search ) ? $request->search : null;
        $order     = isset( $request->order ) ? $request->order : "ASC";
        $column    = isset( $request->column ) ? $request->column : "idventa";
        $paginate  = isset( $request->search ) ? $request->search : 10;

        $functions = new Functions();

        if ( strtoupper( $order ) !== "DESC" ) $order = "ASC";
        if ( !is_numeric( $paginate ) ) $paginate = 10;

        $venta = $query
            ->select( [
                'idventa', 'nota', 'fkidcliente', 'montototal', 'nombre', 'apellido',
                'telefono', 'email', 'ciudad', 'direccion', 'nit',
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

        return $venta;
    }

    public function guardar( $query, $request ) 
    {
        $fkidcliente  = isset( $request->fkidcliente ) ? $request->fkidcliente : null;
        $nota  = isset( $request->nota ) ? $request->nota : null;
        $montototal  = isset( $request->montototal ) ? $request->montototal : null;
        $nombre  = isset( $request->nombre ) ? $request->nombre : null;
        $apellido  = isset( $request->apellido ) ? $request->apellido : null;
        $telefono  = isset( $request->telefono ) ? $request->telefono : null;
        $email  = isset( $request->email ) ? $request->email : null;
        $ciudad  = isset( $request->ciudad ) ? $request->ciudad : null;
        $direccion  = isset( $request->direccion ) ? $request->direccion : null;
        $nit  = isset( $request->nit ) ? $request->nit : null;
        $tipopago  = isset( $request->tipopago ) ? $request->tipopago : null;

        $x_idusuario  = isset( $request->x_idusuario ) ? $request->x_idusuario : null;
        $x_fecha      = isset( $request->x_fecha ) ? $request->x_fecha : null;
        $x_hora       = isset( $request->x_hora ) ? $request->x_hora : null;

        $venta = $query->create( [
            'fkidcliente' => $fkidcliente,
            'nota' => $nota,
            'montototal' => $montototal,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'email' => $email,
            'nit' => $nit,
            'ciudad' => $ciudad,
            'direccion' => $direccion,
            'tipopago' => $tipopago,

            'x_idusuario' => $x_idusuario,
            'x_fecha'     => $x_fecha,
            'x_hora'      => $x_hora,
        ] );

        return $venta;
    }

    public function actualizar( $query, $request ) 
    {
        $idventa = isset( $request->idventa ) ? $request->idventa : null;
        $fkidcliente  = isset( $request->fkidcliente ) ? $request->fkidcliente : null;
        $nota  = isset( $request->nota ) ? $request->nota : null;
        $montototal  = isset( $request->montototal ) ? $request->montototal : null;
        $nombre  = isset( $request->nombre ) ? $request->nombre : null;
        $apellido  = isset( $request->apellido ) ? $request->apellido : null;
        $telefono  = isset( $request->telefono ) ? $request->telefono : null;
        $email  = isset( $request->email ) ? $request->email : null;
        $ciudad  = isset( $request->ciudad ) ? $request->ciudad : null;
        $direccion  = isset( $request->direccion ) ? $request->direccion : null;

        $venta = $query->where( 'idventa', '=', $idventa )
            ->update( [
                'fkidcliente' => $fkidcliente,
                'nota' => $nota,
                'montototal' => $montototal,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'telefono' => $telefono,
                'email' => $email,
                'ciudad' => $ciudad,
                'direccion' => $direccion,
            ] );

        return $venta;
    }

    public function detalle( $query, $idventa )
    {

        $venta = $query
            ->select( [
                'idventa', 'nota', 'fkidcliente', 'montototal', 'nombre', 'apellido',
                'telefono', 'email', 'ciudad', 'direccion', 'nit', 'tipopago',
                'estado', 'isdelete', 'x_fecha', 'x_hora',
            ] )
            ->where( 'idventa', '=', $idventa )
            ->orderBy( 'idventa', 'ASC' )
            ->first();

        return $venta;
    }

}
