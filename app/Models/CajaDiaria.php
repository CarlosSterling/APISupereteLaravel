<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CajaDiaria extends Model
{
    protected $table = 'caja_diaria';

    protected $fillable = [
        'nombre',
        'fecha_apertura',
        'fecha_cierre',
        'saldo_inicial',
        'saldo_final',
        'observacion',
        'abierta_por',
        'cerrada_por',
    ];

    public $timestamps = true;

    // Relaciones a revisar
    public function usuarioAbre()
    {
        return $this->belongsTo(Usuarios::class, 'abierta_por');
    }

    public function usuarioCierra()
    {
        return $this->belongsTo(Usuarios::class, 'cerrada_por');
    }
}

