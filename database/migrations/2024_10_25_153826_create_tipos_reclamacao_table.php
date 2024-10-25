<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposReclamacaoTable extends Migration
{
    public function up()
    {
        Schema::create('tipos_reclamacao', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->text('descricao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos_reclamacao');
    }
}
