<?php

namespace App\Models\Venta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TerrenoServicioDetalle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'terrenoserviciodetalle';
    protected $primaryKey = 'idterrenoserviciodetalle';

    public $timestamps = true;

    protected $dates = [
        "created_at", "updated_at", "deleted_at",
    ];

    protected $attributes = [
        "x_idusuario" => null,
        "isdelete" => "A", "estado" => "A",
    ];

    protected $fillable = [
        "fkidterreno", "fkidservicio",
        "x_idusuario", "x_fecha", "x_hora", "isdelete", "estado",
    ];

}
