<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipamentos extends Model
{
    protected $table = 'equipamentos';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public $fillable = [
        'nome',
        'estoque'
    ];

    public function reservas()
    {
        return $this->hasMany(Reservas::class, 'equipamento_id', 'id');
    }
}
