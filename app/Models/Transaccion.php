<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table = 'transaccion';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'monto',
        'fecha',
        'caja_diaria_id'
    ];

    public function detallesCaja()
    {
        return $this->hasMany(DetallesCaja::class, 'transaccion_id');
    }
}
