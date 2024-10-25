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
        // Renomeia o campo data_criacao para created_at
        $table->renameColumn('data_criacao', 'created_at');

        // Adiciona o campo updated_at
        $table->timestamp('updated_at')->nullable();
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
