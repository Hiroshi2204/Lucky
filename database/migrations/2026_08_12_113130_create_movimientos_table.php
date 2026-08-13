<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_id')
                ->constrained('productos')
                ->cascadeOnDelete();

            $table->enum('tipo', [
                'ENTRADA',
                'SALIDA'
            ]);

            $table->decimal('cantidad', 12, 3);

            $table->dateTime('fecha')->useCurrent();

            $table->string('observacion')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos');
    }
};