<?php

namespace App\Http\Controllers;

use App\Models\Sessoes;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class LoginController extends Controller
{
    public function retornarCredencial(Request $request)
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
                'mnesagem' => 'Sessão não encontrada'
            ], 404);
        }

        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Sessão encontrada',
            'dados' => $sessao
        ], 200);
    }
}
