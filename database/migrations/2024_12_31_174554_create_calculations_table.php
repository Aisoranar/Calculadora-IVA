<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculationsTable extends Migration
{
    public function up()
    {
        Schema::create('calculations', function (Blueprint $table) {
            $table->id();
            $table->decimal('value', 10, 2); // Valor ingresado por el usuario
            $table->decimal('iva', 5, 2);   // IVA utilizado en el cálculo
            $table->decimal('result', 10, 2); // Resultado del cálculo
            $table->string('type');         // Tipo de cálculo ('sin_iva', 'con_iva', etc.)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calculations');
    }
}
