<?php

namespace App\Models\Venta;

use App\Models\Functions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Terreno extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'terreno';
    protected $primaryKey = 'idterreno';

    public $timestamps = true;

    protected $dates = [
        "created_at", "updated_at", "deleted_at",
    ];

    protected $attributes = [
        "nota" => null, "latitud" => null, "longitud" => null, "precio" => 0,
        "x_idusuario" => null,
        "isdelete" => "A", "estado" => "A",
    ];

    protected $fillable = [
        "descripcion", "nota", "latitud", "longitud", "ciudad", "direccion", "precio", "imagen",
        "x_idusuario", "x_fecha", "x_hora", "isdelete", "estado",
    ];

    public function get_data( $query, $request ) {

        $search = isset( $request->search ) ? $request->search : null;
        $order = isset( $request->order ) ? $request->order : "ASC";
        $column = isset( $request->column ) ? $request->column : "terreno.idterreno";

        $functions = new Functions();

        if ( strtoupper( $order ) !== "DESC" ) $order = "ASC";

        $terreno = $query
            ->select( [
                'terreno.idterreno', 'terreno.descripcion', 'terreno.nota', 
                'terreno.latitud', 'terreno.longitud', 'terreno.precio', 'terreno.ciudad', 'terreno.direccion',
                'terreno.estado', 'terreno.isdelete', 'terreno.x_fecha', 'terreno.x_hora', 'terreno.imagen',
                'pago.idplandepago', 'pago.nrocuota', 'pago.anticipo', 'pago.tipopago'
            ] )
            ->leftJoin( 'plandepago as pago', 'terreno.idterreno', '=', 'pago.fkidterreno' )
            ->where( function ( $query ) use ( $search, $functions ) {
                if ( !is_null( $search ) ) {
                    return $query->where( 'terreno.descripcion', $functions->isLikeOrIlike(), "%" . $search . "%" );
                }
                return;
            } )
            ->orderBy( $column, $order )
            ->get();

        return $terreno;
    }

    public function get_paginate( $query, $request ) {

        $search    = isset( $request->search ) ? $request->search : null;
        $order     = isset( $request->order ) ? $request->order : "ASC";
        $column    = isset( $request->column ) ? $request->column : "idterreno";
        $paginate  = isset( $request->search ) ? $request->search : 10;

        $functions = new Functions();

        if ( strtoupper( $order ) !== "DESC" ) $order = "ASC";
        if ( !is_numeric( $paginate ) ) $paginate = 10;

        $terreno = $query
            ->select( [
                'idterreno', 'descripcion', 'nota', 'latitud', 'longitud', 'precio', 'ciudad', 'direccion',
                'estado', 'isdelete', 'x_fecha', 'x_hora', 'imagen',
            ] )
            ->where( function ( $query ) use ( $search, $functions ) {
                if ( !is_null( $search ) ) {
                    return $query->where( 'descripcion', $functions->isLikeOrIlike(), "%" . $search . "%" );
                }
                return;
            } )
            ->orderBy( $column, $order )
            ->paginate($paginate);

        return $terreno;
    }

    public function guardar( $query, $request ) 
    {
        $descripcion  = isset( $request->descripcion ) ? $request->descripcion : null;
        $nota         = isset( $request->nota ) ? $request->nota : null;

        $latitud    = isset( $request->latitud ) ? $request->latitud : null;
        $longitud    = isset( $request->longitud ) ? $request->longitud : null;
        $precio    = isset( $request->precio ) ? $request->precio : null;
        $ciudad    = isset( $request->ciudad ) ? $request->ciudad : null;
        $direccion    = isset( $request->direccion ) ? $request->direccion : null;
        $imagen    = isset( $request->imagen ) ? $request->imagen : null;

        $x_idusuario  = isset( $request->x_idusuario ) ? $request->x_idusuario : null;
        $x_fecha      = isset( $request->x_fecha ) ? $request->x_fecha : null;
        $x_hora       = isset( $request->x_hora ) ? $request->x_hora : null;

        $terreno = $query->create( [
            'descripcion' => $descripcion,
            'nota' => $nota,
            'latitud' => $latitud,
            'longitud' => $longitud,
            'precio' => $precio,
            'ciudad' => $ciudad,
            'direccion' => $direccion,
            'imagen' => $imagen,

            'x_idusuario' => $x_idusuario,
            'x_fecha'     => $x_fecha,
            'x_hora'      => $x_hora,
        ] );

        return $terreno;
    }

    public function actualizar( $query, $request ) 
    {
        $idterreno = isset( $request->idterreno ) ? $request->idterreno : null;
        $descripcion    = isset( $request->descripcion ) ? $request->descripcion : null;
        $nota    = isset( $request->nota ) ? $request->nota : null;
        $latitud    = isset( $request->latitud ) ? $request->latitud : null;
        $longitud    = isset( $request->longitud ) ? $request->longitud : null;
        $precio    = isset( $request->precio ) ? $request->precio : null;
        $ciudad    = isset( $request->ciudad ) ? $request->ciudad : null;
        $direccion    = isset( $request->direccion ) ? $request->direccion : null;
        $imagen    = isset( $request->imagen ) ? $request->imagen : null;

        $terrenofirst = $query
            ->select( [
                'idterreno', 'descripcion', 'nota', 'latitud', 'longitud', 'precio', 'ciudad', 'direccion',
                'estado', 'isdelete', 'x_fecha', 'x_hora', 'imagen',
            ] )
            ->where( 'idterreno', '=', $idterreno )
            ->orderBy( 'idterreno', 'ASC' )
            ->first();

        $terreno = $query->where( 'idterreno', '=', $idterreno )
            ->update( [
                'descripcion' => $descripcion,
                'nota' => $nota,
                'latitud' => $latitud,
                'longitud' => $longitud,
                'precio' => $precio,
                'ciudad' => $ciudad,
                'direccion' => $direccion,
                'imagen' => is_null( $imagen ) ? $terrenofirst->imagen : $imagen,
            ] );

        return $terreno;
    }

    public function detalle( $query, $idterreno )
    {

        $terreno = $query
            ->select( [
                'idterreno', 'descripcion', 'nota', 'latitud', 'longitud', 'precio', 'ciudad', 'direccion',
                'estado', 'isdelete', 'x_fecha', 'x_hora', 'imagen',
            ] )
            ->where( 'idterreno', '=', $idterreno )
            ->orderBy( 'idterreno', 'ASC' )
            ->first();

        return $terreno;
    }

}
