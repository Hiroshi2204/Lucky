<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            $table->dateTime('fecha')->useCurrent();

            $table->decimal('total', 14, 2)->default(0);

            $table->enum('medio_pago', [
                'EFECTIVO',
                'DEPOSITO',
                'TRANSFERENCIA',
                'OTRO'
            ]);

            $table->string('medio_pago_otro')->nullable();

            $table->enum('estado_pago', [
                'CANCELADO',
                'PENDIENTE',
                'PARCIAL',
                'OTRO'
            ])->default('CANCELADO');

            $table->decimal('monto_pagado', 14, 2)->default(0);

            $table->decimal('saldo_pendiente', 14, 2)->default(0);

            $table->text('observacion')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};