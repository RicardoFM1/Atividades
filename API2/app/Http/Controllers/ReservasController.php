<?php

namespace App\Http\Controllers;

use App\Models\Reservas;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class ReservasController extends Controller
{
    public function listarReservasPorEquipamento(Request $request)
    {
        $equipamentoId = intval($request->query('equipamento_id'));
        $reservas = [];
        if (!empty($equipamentoId)) {
            $reservas = Reservas::where('equipamento_id', $equipamentoId)->get();
        } else {
            $reservas = Reservas::all();
        }

        return response()->json([
            'sucesso' => true,
            'dados' => $reservas
        ], 200);
    }

    public function criarReserva(Request $request)
    {
        try {
            $dadosValidados = $this->validate($request, Reservas::regras(), Reservas::mensagens());

            $criar = Reservas::create($dadosValidados);

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Reserva criada com sucesso'
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Erro ao tentar criar reserva'
            ], 400);
        }
    }


    public function deletarReserva($reservaId)
    {
        try {
            $reserva = Reservas::where('id', $reservaId)->first();

            if (empty($reserva)) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Reserva não encontrada'
                ], 404);
            }

            $reserva->delete();

            return response()->json("", 204);
        } catch (QueryException $e) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Erro ao tentar deletar reserva'
            ], 400);
        }
    }
}
