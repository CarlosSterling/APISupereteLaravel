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
        Schema::create('caja_diaria', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->timestampTz('fecha_apertura', 0)->useCurrent();
            $table->timestampTz('fecha_cierre', 0)->nullable()->default(null);
            $table->decimal('saldo_inicial', 10, 2);
            $table->decimal('saldo_final', 10, 2)->nullable();
            $table->text('observacion');
            $table->unsignedBigInteger('abierta_por');
            $table->unsignedBigInteger('cerrada_por')->nullable();
            $table->timestamps();

            $table->foreign('abierta_por')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('cerrada_por')
                ->references('id')
                ->on('usuarios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_diaria');
    }
};
