<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->string('paciente');
            $table->string('medico');
            $table->date('fecha');
            $table->date('fechaDeseada');
            $table->date('fechaCita');
            $table->datetime('horaCita');
            $table->datetime('hora');
            $table->string('rips');
            $table->string('entidad');
            $table->string('autorizacion')->nullable();
            $table->string('observaciones')->nullable();


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
        Schema::dropIfExists('citas');
    }
}
