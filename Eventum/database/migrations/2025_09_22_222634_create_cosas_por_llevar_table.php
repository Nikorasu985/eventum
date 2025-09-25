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
        Schema::create('cosas_por_llevar', function (Blueprint $table) {
            $table->id('id_cosa');
            $table->foreignId('id_evento')->constrained('eventos', 'id_evento');
            $table->string('nombre', 100);
            $table->string('cantidad', 50)->nullable();
            $table->foreignId('id_usuario')->nullable()->constrained('usuarios', 'id_usuario');
            $table->enum('estado', ['pendiente', 'comprado', 'cancelado'])->default('pendiente');
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('cosas_por_llevar');
    }
};
