<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('codeps');
            $table->string('tipidafil');
            $table->string('afcodigo');
            $table->string('afape1');
            $table->string('afape2')->nullable();
            $table->string('afnom1');
            $table->string('afnom2')->nullable();
            $table->date('fecha_nacimiento');
            $table->string('sexo');
            $table->string('telefono');
            $table->string('direccion')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
