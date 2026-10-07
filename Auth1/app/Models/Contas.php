<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contas extends Model {
    protected $table = 'contas';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public $fillable = [
        'email',
        'senha_hash'
    ];

    public function sessoes (){
        return $this->hasMany(Sessoes::class, 'conta_id', 'id');
    }
}