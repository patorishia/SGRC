<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;
     protected $table = 'estados';

     protected $fillable = ['nome'];
 
     // Define o relacionamento com o modelo Reclamacao
     public function reclamacoes()
     {
         return $this->hasMany(Reclamacao::class, 'estados');
     }
}