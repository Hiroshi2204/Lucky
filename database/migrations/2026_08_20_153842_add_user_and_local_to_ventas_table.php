<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('local_id')
                ->nullable()
                ->after('user_id')
                ->constrained('locales')
                ->restrictOnDelete();
        });
    }

    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropForeign(['local_id']);

            $table->dropColumn([
                'user_id',
                'local_id'
            ]);
        });
    }
};