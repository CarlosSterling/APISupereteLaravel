<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DetallesCaja extends Model
{
    protected $table = 'detalle_caja';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'monto',
        'fecha',
        'caja_diaria_id',
        'transaccion_id',
    ];

    // Si tu tabla no tiene created_at y updated_at:
    // public $timestamps = false;

    public function cajaDiaria()
    {
        return $this->belongsTo(CajaDiaria::class, 'caja_diaria_id');
    }

    public function transaccion()
    {
        return $this->belongsTo(Transaccion::class, 'transaccion_id');
    }
}
