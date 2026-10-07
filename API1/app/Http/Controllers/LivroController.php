<?php

namespace App\Http\Controllers;

use App\Models\Livros;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class LivroController extends Controller
{
    public function listarLivros(Request $request)
    {
        $livros = [];
        $titulo = $request->query('titulo');
        $autor = $request->query('autor');
        $categoria = $request->query('categoria');



        if (empty($titulo) && empty($autor) && empty($categoria)) {
            $livros = Livros::all();
        }

        if (!empty($titulo)) {
            $livros = Livros::where('titulo', 'like', "%" . $titulo . "%")->get();
            if (empty($livros)) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Nenhum livro encontrado com esse titulo'
                ], 404);
            }
        }

        if (!empty($autor)) {
            $livros = Livros::where('autor', 'like', "%" . $autor . "%")->get();
            if (empty($livros)) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Nenhum livro encontrado com esse autor'
                ], 404);
            }
        }

        if (!empty($categoria)) {
            $livros = Livros::where('categoria', 'like', "%" . $categoria . "%")->get();
            if (empty($livros)) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Nenhum livro encontrado com essa categoria'
                ], 404);
            }
        }

        if (!empty($autor) && !empty($titulo) && !empty($categoria)) {
            $livros = Livros::where('autor', 'like', "%" . $autor . "%")->where('titulo', 'like', "%" . $titulo . "%")
                ->where('categoria', 'like', '%' . $categoria . '%')->get();

            if (empty($livros)) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'Nenhum livro encontrado com esse autor e titulo'
                ], 404);
            }
        }


        if (empty($livros)) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Nenhum livro encontrado'
            ], 404);
        } else {

            return response()->json([
                'sucesso' => true,
                'dados' => $livros
            ], 200);
        }
    }
}
