<?php

namespace App\Models\Venta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VentaDetalle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ventadetalle';
    protected $primaryKey = 'idventadetalle';

    public $timestamps = true;

    protected $dates = [
        "created_at", "updated_at", "deleted_at",
    ];

    protected $attributes = [
        "precio" => 0, "cantidad" => 0, "nota" => null,
        "x_idusuario" => null,
        "isdelete" => "A", "estado" => "A",
    ];

    protected $fillable = [
        "fkidventa", "fkidterreno", "precio", "cantidad", "nota",
        "x_idusuario", "x_fecha", "x_hora", "isdelete", "estado",
    ];

}
