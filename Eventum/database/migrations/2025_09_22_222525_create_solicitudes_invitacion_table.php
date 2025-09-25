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
        Schema::create('solicitudes_invitacion', function (Blueprint $table) {
            $table->id('id_solicitud');
            $table->foreignId('id_evento')->constrained('eventos', 'id_evento');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->foreignId('id_tipo_solicitud')->constrained('tipos_solicitud', 'id_tipo_solicitud');
            $table->foreignId('id_estado_solicitud')->default(1)->constrained('estados_solicitud', 'id_estado_solicitud');
            $table->text('mensaje')->nullable();
            $table->timestamp('fecha_envio')->useCurrent();
            $table->unique(['id_evento', 'id_usuario']);
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
        Schema::dropIfExists('solicitudes_invitacion');
    }
};
