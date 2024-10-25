<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTimestampsFromTiposReclamacao extends Migration
{
    public function up()
    {
        Schema::table('tipos_reclamacao', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }

    public function down()
    {
        Schema::table('tipos_reclamacao', function (Blueprint $table) {
            $table->timestamps();
        });
    }
}
