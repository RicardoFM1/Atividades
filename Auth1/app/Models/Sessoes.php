<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sessoes extends Model
{
    protected $table = 'sessoes';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public $fillable = [
        'id',
        'tipo',
        'numero',
        'conta_id'
    ];

    public function contas()
    {
        return $this->belongsTo(Contas::class, 'conta_id', 'id');
    }
}
