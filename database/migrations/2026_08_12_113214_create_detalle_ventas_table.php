<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('venta_id')
                ->constrained('ventas')
                ->cascadeOnDelete();

            $table->foreignId('producto_id')
                ->constrained('productos')
                ->restrictOnDelete();

            $table->decimal('cantidad', 12, 3);

            $table->decimal('precio_unitario', 14, 2);

            $table->decimal('precio_total', 14, 2);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_ventas');
    }
};