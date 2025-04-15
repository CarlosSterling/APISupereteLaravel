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
        Schema::create('transaccion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo'); // 'compra' o 'venta'
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->timestampTz('fecha', 0);
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();

            $table->foreign('producto_id')
                ->references('id')
                ->on('productos')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('usuario_id')
                ->references('id')
                ->on('usuarios')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaccion');
    }
};
