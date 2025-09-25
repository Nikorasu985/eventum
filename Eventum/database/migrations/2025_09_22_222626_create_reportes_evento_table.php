<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes_evento', function (Blueprint $table) {
            $table->id('id_reporte');
            $table->foreignId('id_evento')->constrained('eventos', 'id_evento');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->text('motivo');
            $table->timestamp('fecha_reporte')->useCurrent();
            $table->enum('estado', ['pendiente', 'revisado', 'rechazado'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reportes_evento');
    }
};
