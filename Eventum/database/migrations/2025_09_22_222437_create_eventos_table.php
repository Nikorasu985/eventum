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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id('id_evento');
            $table->foreignId('id_anfitrion')->constrained('usuarios', 'id_usuario');
            $table->string('titulo', 150);
            $table->text('descripcion')->nullable();
            $table->string('lugar', 150)->nullable();
            $table->string('sitio', 150)->nullable();
            $table->foreignId('id_tipo_presupuesto')->default(2)->constrained('tipos_presupuesto', 'id_tipo_presupuesto');
            $table->decimal('presupuesto', 10, 2)->nullable();
            $table->integer('numero_integrantes')->default(0);
            $table->string('codigo_evento', 20)->unique()->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->time('hora_fin')->nullable();
            $table->date('fecha_limite_invitacion')->nullable();
            $table->timestamp('fecha_creacion')->useCurrent();
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
        Schema::dropIfExists('eventos');
    }
};
