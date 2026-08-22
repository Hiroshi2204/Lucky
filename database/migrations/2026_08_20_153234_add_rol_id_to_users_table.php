<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->foreignId('rol_id')
                ->nullable()
                ->after('persona_id')
                ->constrained('rol')
                ->restrictOnDelete();

        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['rol_id']);
            $table->dropColumn('rol_id');

        });
    }
};