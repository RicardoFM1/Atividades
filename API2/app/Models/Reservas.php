<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    protected $table = 'reservas';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public $fillable = [
        'equipamento_id',
        'solicitante',
        'quantidade',
        'data_retirada',
        'data_devolucao'
    ];

    public static function regras()
    {
        return [
            'equipamento_id' => 'required|integer',
            'solicitante' => 'required|string',
            'quantidade' => 'required|integer',
            'data_retirada' => 'required|date',
            'data_devolucao' => 'required|date'
        ];
    }

    public static function mensagens()
    {
        return [
            'equipamento_id.required' => 'A referência do equipamento é obrigatória',
            'equipamento_id.integer' => 'A referência do equipamento deve ser um número inteiro',
            'solicitante.required' => 'O campo solicitante é obrigatório',
            'solicitante.string' => 'O campo solicitante deve ser um texto',
            'quantidade.required' => 'O campo quantidade é obrigatório',
            'quantidade.integer' => 'O campo quantidade deve ser um número inteiro',
            'data_retirada.required' => 'O campo data_retirada é obrigatório',
            'data_retirada.date' => 'O campo data_retirada deve ser uma data',
            'data_devolucao.required' => 'O campo data_devolucao é obrigatório',
            'data_devolucao.date' => 'O campo data_devolucao deve ser uma data',
        ];
    }

    public function equipamentos()
    {
        return $this->belongsTo(Equipamentos::class, 'equipamento_id', 'id');
    }
}
