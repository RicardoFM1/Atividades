<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livros extends Model {
    protected $table = 'livros';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $fillable = [
        'titulo',
        'autor',
        'categoria',
        'ano',
        'paginas'
    ];


}