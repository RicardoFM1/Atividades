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
                !is_array($corpo) || $corpo === []
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

            $dataRetirada = $request->input('data_retirada');
            $dataDevolucao = $request->input('data_devolucao');

            $diferencaDias = Carbon::parse($dataDevolucao)->diffInDays($dataRetirada);

            if ($diferencaDias > 7) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'O prazo máximo é de 7 dias'
                ], 422);
            }

            $aberturaMaiorQueConclusao = Carbon::parse($dataRetirada)->greaterThan($dataDevolucao);

            if ($aberturaMaiorQueConclusao) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Período inválido, a data de retirada deve ser menor que a data de devolução'
                ], 422);
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

            $reservados = Reservas::where('equipamento_id', $equipamento->id)
            ->where('data_retirada', '<', $dataDevolucao)
            ->where('data_devolucao', '>', $dataRetirada)
            ->sum('quantidade');

            $disponivel = $equipamento->estoque - $reservados;

            if($request->input('quantidade') > $disponivel){
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Estoque insuficiente no período, disponível: ' . $disponivel
                ], 409);
            }


            $criar = Reservas::create($dadosValidados);

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
