<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marca extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }
}
