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
        Schema::create('asignaturas_profesores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fk_profesor');
            $table->foreignId('fk_asignatura');
            $table->foreign('fk_profesor')->references('id')->on('profesores');
            $table->foreign('fk_asignatura')->references('id')->on('asignaturas');
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
        Schema::dropIfExists('asignaturas_profesores');
    }
};
