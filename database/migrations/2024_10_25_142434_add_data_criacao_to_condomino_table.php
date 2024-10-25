<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCondominoTable extends Migration
{
    public function up()
    {
        Schema::create('condomino', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->string('telefone');
            $table->foreignId('condominio_id')->constrained('condominios');
            $table->timestamps(); // Isso cria os campos created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('condomino');
    }
}
