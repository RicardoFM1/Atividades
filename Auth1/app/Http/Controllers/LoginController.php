<?php

namespace App\Http\Controllers;

use App\Models\Contas;
use App\Models\Sessoes;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class LoginController extends Controller
{
    public function enviarCredencial(Request $request)
    {
        $numero = $request->input('name');
        if (empty($numero)) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Name é necessário'
            ], 422);
        }

        $sessao = Sessoes::where('numero', $numero)->first();

        if (empty($sessao)) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Sessão não encontrada'
            ], 404);
        }

        setcookie('sessao', $sessao->codigo);

        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Sessão encontrada',
            'dados' => $sessao
        ], 200);
    }

    public function LoginPorCredencial($numero)
    {
        try {

            $codigo = rand(100000000000000000, 20000000000000000);

            Sessoes::create([
                'id' => $codigo,
                'tipo' => 'cracha',
                'numero' => $numero
            ]);

            redirect('/painel');
            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Logado com sucesso pela credencial',
                'cookie' => htmlspecialchars($_COOKIE['sessao'])
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Erro ao tentar fazer login por credencial' . $e->getMessage()
            ], 400);
        }
    }

    public function painel()
    {

        $cookie = htmlspecialchars($_COOKIE['sessao']);

        $sessaoOperador = Sessoes::where('id', $cookie)->first();

        if (empty($sessaoOperador)) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Sessão não encontrada',
                'cookie' => $cookie
            ], 404);
        }

        if (empty($sessao)) {
            redirect('/login');
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Sem sessão'
            ], 401);
        }

        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Acesso liberado para o painel',
            'numero_operador' => $sessaoOperador->numero
        ], 200);
    }

   
}
