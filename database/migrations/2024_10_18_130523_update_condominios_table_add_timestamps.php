<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('condominios', function (Blueprint $table) {
       // Renomear as colunas 'data_criacao' e 'ultima_atualizacao' para 'created_at' e 'updated_at'
       $table->renameColumn('data_criacao', 'created_at');
       $table->renameColumn('ultima_atualizacao', 'updated_at');

    });
}

public function down()
{
    Schema::table('condominios', function (Blueprint $table) {
        // Reverte as alterações
        $table->renameColumn('created_at', 'data_criacao');
        $table->dropColumn('updated_at');
    });
}

};
