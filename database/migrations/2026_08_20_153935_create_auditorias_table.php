<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('auditorias', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('local_id')
                ->nullable()
                ->constrained('locales')
                ->nullOnDelete();

            $table->string('accion', 50);

            $table->string('tabla', 100)->nullable();

            $table->unsignedBigInteger('registro_id')->nullable();

            $table->text('descripcion')->nullable();

            $table->json('datos_anteriores')->nullable();

            $table->json('datos_nuevos')->nullable();

            $table->string('ip', 45)->nullable();

            $table->text('user_agent')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index(['tabla', 'registro_id']);
            $table->index(['user_id']);
            $table->index(['local_id']);
            $table->index(['accion']);
            $table->index(['created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('auditorias');
    }
};