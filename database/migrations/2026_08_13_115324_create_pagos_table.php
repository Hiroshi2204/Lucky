<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('venta_id')
                ->constrained('ventas')
                ->cascadeOnDelete();

            $table->decimal('monto', 14, 2);

            $table->enum('medio_pago', [
                'EFECTIVO',
                'DEPOSITO',
                'TRANSFERENCIA',
                'OTRO'
            ]);

            $table->string('medio_pago_otro')
                ->nullable();

            $table->dateTime('fecha')
                ->useCurrent();

            $table->text('observacion')
                ->nullable();


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos');
    }
};