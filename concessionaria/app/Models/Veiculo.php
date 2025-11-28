<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Veiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'modelo',
        'ano',
        'preco',
        'marca_id',
        'foto',
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }
}
