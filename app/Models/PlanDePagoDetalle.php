<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanDePagoDetalle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'plandepagodetalle';
    protected $primaryKey = 'idplandepagodetalle';

    public $timestamps = true;

    protected $dates = [
        "created_at", "updated_at", "deleted_at",
    ];

    protected $attributes = [
        "x_idusuario" => null,
        "isdelete" => "A", "estado" => "A",
    ];

    protected $fillable = [
        "fkidplandepago", "fkidventa", "montoapagar", "nrocuota", "fechaapagar", "estadoproceso",
        "x_idusuario", "x_fecha", "x_hora", "isdelete", "estado",
    ];

}
