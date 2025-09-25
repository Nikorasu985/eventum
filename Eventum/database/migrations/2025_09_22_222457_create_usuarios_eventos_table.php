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
        Schema::create('usuarios_eventos', function (Blueprint $table) {
            $table->id('id_usuario_evento');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->foreignId('id_evento')->constrained('eventos', 'id_evento');
            $table->foreignId('id_rol_evento')->constrained('roles_evento', 'id_rol_evento');
            $table->enum('estado_invitacion', ['pendiente', 'aceptado', 'rechazado'])->default('pendiente');
            $table->unique(['id_usuario', 'id_evento']);
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
        Schema::dropIfExists('usuarios_eventos');
    }
};
