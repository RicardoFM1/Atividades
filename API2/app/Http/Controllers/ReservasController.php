<?php

namespace App\Http\Controllers;

use App\Models\Equipamentos;
use App\Models\Reservas;
use Carbon\Carbon;
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
            if (empty($reservas)) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Reserva não encontrada pelo equipamento'
                ], 404);
            }
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
            $corpo = json_decode($request->getContent(), true);

            if (
                json_last_error() !== JSON_ERROR_NONE ||
                !is_array($corpo) || $corpo !== []
            ) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'JSON inválido'
                ], 400);
            }

            $dadosValidados = $this->validate($request, Reservas::regras(), Reservas::mensagens());
            $equipamento = Equipamentos::where('id', $request->input('equipamento_id'))->first();
            if (empty($equipamento)) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Equipamento não encontrado'
                ], 404);
            }

            if ($request->input('quantidade') <= 0) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Quantidade inválida'
                ], 422);
            }

            if ($request->input('quantidade') > $equipamento->estoque) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Não há estoque disponível para esse equipamento'
                ], 422);
            }


            $criar = Reservas::create($dadosValidados);
            $estoqueNovo = $equipamento->estoque - $request->input('quantidade');
            $equipamento->update(['estoque' => $estoqueNovo]);

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Reserva criada com sucesso',
                'dados' => $criar
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
