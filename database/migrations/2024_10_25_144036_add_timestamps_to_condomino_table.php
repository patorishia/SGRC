<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToCondominoTable extends Migration
{
    public function up()
    {
        Schema::table('condomino', function (Blueprint $table) {
            $table->timestamps(); // Isso adiciona as colunas created_at e updated_at
        });
    }

    public function down()
    {
        Schema::table('condomino', function (Blueprint $table) {
            $table->dropTimestamps(); // Remove as colunas se necessário
        });
    }
}

