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
        Schema::create('participaciones', function (Blueprint $table) {
            $table->id('id_participacion');
            $table->foreignId('id_evento')->constrained('eventos', 'id_evento');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->timestamp('fecha_confirmacion')->useCurrent();
            $table->foreignId('id_estado_participacion')->default(1)->constrained('estados_participacion', 'id_estado_participacion');
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
        Schema::dropIfExists('participaciones');
    }
};
