<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TipoReclamacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_reclamacao')->insert([
            ['tipo' => 'Reclamação sobre Barulho'],
            ['tipo' => 'Reclamação sobre Limpeza'],
            ['tipo' => 'Reclamação sobre Segurança'],
            ['tipo' => 'Reclamação sobre Vandalismo'],
            ['tipo' => 'Reclamação sobre Obras'],
            ['tipo' => 'Reclamação sobre Funcionários'],
        ]);
    }
}
