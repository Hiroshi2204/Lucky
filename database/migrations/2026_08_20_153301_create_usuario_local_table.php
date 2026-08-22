<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuario_local', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('local_id')
                ->constrained('locales')
                ->cascadeOnDelete();

            $table->boolean('estado')->default(true);

            $table->timestamps();

            $table->unique(['user_id', 'local_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario_local');
    }
};