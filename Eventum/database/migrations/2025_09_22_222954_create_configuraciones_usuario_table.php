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
        Schema::create('configuraciones_usuario', function (Blueprint $table) {
            $table->id('id_configuracion');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->string('tema', 50)->default('futurista');
            $table->string('modo_oscuro', 10)->default('auto');
            $table->json('colores_personalizados')->nullable();
            $table->json('configuracion_dashboard')->nullable();
            $table->json('notificaciones_config')->nullable();
            $table->string('idioma', 5)->default('es');
            $table->string('zona_horaria', 50)->default('America/Mexico_City');
            $table->boolean('animaciones_habilitadas')->default(true);
            $table->integer('tamaño_fuente')->default(16);
            $table->string('tipo_fuente', 50)->default('Inter');
            $table->json('widgets_dashboard')->nullable();
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
        Schema::dropIfExists('configuraciones_usuario');
    }
};
