<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {

            $table->foreignId('local_id')
                ->nullable()
                ->after('id')
                ->constrained('locales')
                ->restrictOnDelete();

        });

        Schema::table('productos', function (Blueprint $table) {

            $table->dropUnique('productos_codigo_unique');

            $table->unique(
                ['local_id', 'codigo'],
                'productos_local_codigo_unique'
            );

        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {

            $table->dropUnique('productos_local_codigo_unique');

            $table->unique(
                'codigo',
                'productos_codigo_unique'
            );

            $table->dropForeign(['local_id']);
            $table->dropColumn('local_id');

        });
    }
};