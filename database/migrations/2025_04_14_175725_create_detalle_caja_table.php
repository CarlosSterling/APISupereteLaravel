<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detalle_caja', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->text('descripcion');
            $table->string('tipo'); // 'ingreso' o 'egreso'
            $table->decimal('monto', 10, 2);
            $table->timestampTz('fecha', 0);
            $table->unsignedBigInteger('caja_diaria_id');
            $table->unsignedBigInteger('transaccion_id');
            $table->timestamps();

            $table->foreign('caja_diaria_id')
                ->references('id')
                ->on('caja_diaria')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('transaccion_id')
                ->references('id')
                ->on('transaccion')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_caja');
    }
};
