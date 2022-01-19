<?php

namespace App\Models\Venta;

use App\Models\Functions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servicio';
    protected $primaryKey = 'idservicio';

    public $timestamps = true;

    protected $dates = [
        "created_at", "updated_at", "deleted_at",
    ];

    protected $attributes = [
        "x_idusuario" => null,
        "isdelete" => "A", "estado" => "A",
    ];

    protected $fillable = [
        "descripcion",
        "x_idusuario", "x_fecha", "x_hora", "isdelete", "estado",
    ];

    public function get_data( $query, $request ) {

        $search = isset( $request->search ) ? $request->search : null;
        $order = isset( $request->order ) ? $request->order : "ASC";
        $column = isset( $request->column ) ? $request->column : "idservicio";

        $functions = new Functions();

        if ( strtoupper( $order ) !== "DESC" ) $order = "ASC";

        $servicio = $query
            ->select( [
                'idservicio', 'descripcion',
                'estado', 'isdelete', 'x_fecha', 'x_hora',
            ] )
            ->where( function ( $query ) use ( $search, $functions ) {
                if ( !is_null( $search ) ) {
                    return $query->where( 'descripcion', $functions->isLikeOrIlike(), "%" . $search . "%" );
                }
                return;
            } )
            ->orderBy( $column, $order )
            ->get();

        return $servicio;
    }

    public function get_paginate( $query, $request ) {

        $search    = isset( $request->search ) ? $request->search : null;
        $order     = isset( $request->order ) ? $request->order : "ASC";
        $column    = isset( $request->column ) ? $request->column : "idservicio";
        $paginate  = isset( $request->search ) ? $request->search : 10;

        $functions = new Functions();

        if ( strtoupper( $order ) !== "DESC" ) $order = "ASC";
        if ( !is_numeric( $paginate ) ) $paginate = 10;

        $servicio = $query
            ->select( [
                'idservicio', 'descripcion',
                'estado', 'isdelete', 'x_fecha', 'x_hora',
            ] )
            ->where( function ( $query ) use ( $search, $functions ) {
                if ( !is_null( $search ) ) {
                    return $query->where( 'descripcion', $functions->isLikeOrIlike(), "%" . $search . "%" );
                }
                return;
            } )
            ->orderBy( $column, $order )
            ->paginate($paginate);

        return $servicio;
    }

    public function guardar( $query, $request ) 
    {
        $descripcion  = isset( $request->descripcion ) ? $request->descripcion : null;

        $x_idusuario  = isset( $request->x_idusuario ) ? $request->x_idusuario : null;
        $x_fecha      = isset( $request->x_fecha ) ? $request->x_fecha : null;
        $x_hora       = isset( $request->x_hora ) ? $request->x_hora : null;

        $servicio = $query->create( [
            'descripcion' => $descripcion,

            'x_idusuario' => $x_idusuario,
            'x_fecha'     => $x_fecha,
            'x_hora'      => $x_hora,
        ] );

        return $servicio;
    }

    public function actualizar( $query, $request ) 
    {
        $idservicio = isset( $request->idservicio ) ? $request->idservicio : null;
        $descripcion    = isset( $request->descripcion ) ? $request->descripcion : null;

        $servicio = $query->where( 'idservicio', '=', $idservicio )
            ->update( [
                'descripcion' => $descripcion,
            ] );

        return $servicio;
    }

    public function detalle( $query, $idservicio )
    {

        $servicio = $query
            ->select( [
                'idservicio', 'descripcion',
                'estado', 'isdelete', 'x_fecha', 'x_hora',
            ] )
            ->where( 'idservicio', '=', $idservicio )
            ->orderBy( 'idservicio', 'ASC' )
            ->first();

        return $servicio;
    }
    
}
