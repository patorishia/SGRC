<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reclamacao', function (Blueprint $table) {
            // Alterar 'tipo_reclamacao' para 'tipo_reclamacao_id' como chave estrangeira
            $table->unsignedBigInteger('tipo_reclamacao_id')->nullable()->after('descricao'); // Adiciona a nova coluna
            
            // Configurar a chave estrangeira para a tabela 'tipos_reclamacao'
            $table->foreign('tipo_reclamacao_id')
                  ->references('id')
                  ->on('tipos_reclamacao')
                  ->onDelete('set null'); // Define o que acontece quando o tipo de reclamação for excluído
            
            // Renomear as colunas 'data_criacao' e 'ultima_atualizacao' para 'created_at' e 'updated_at'
            $table->renameColumn('data_criacao', 'created_at');
            $table->renameColumn('ultima_atualizacao', 'updated_at');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reclamacao', function (Blueprint $table) {
            // Reverter as mudanças
            $table->dropForeign(['tipo_reclamacao_id']);
            $table->dropColumn('tipo_reclamacao_id');
            
            // Renomear de volta para 'data_criacao' e 'ultima_atualizacao'
            $table->renameColumn('created_at', 'data_criacao');
            $table->renameColumn('updated_at', 'ultima_atualizacao');
        });
    }
};
