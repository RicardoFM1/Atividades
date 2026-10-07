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
        $livrosTotais = [];
        $titulo = $request->query('titulo');
        $autor = $request->query('autor');
        $categoria = $request->query('categoria');
        $pagina = $request->query('pagina');

        if (empty(intval($pagina)) || $pagina === null) {
           

                $livros = Livros::orderBy('titulo', 'DESC')->get();
        }

        if (!empty($pagina) || $pagina !== null) {

            if (empty($titulo) && empty($autor) && empty($categoria)) {

                if (intval($pagina) <= 0) {
                    return response()->json([
                        'sucesso' => false,
                        'mensagem' => 'Página inválida'
                    ], 422);
                }
                if (intval($pagina) === 1) {
                    $livros = Livros::offset(0)->limit(8)->get();
                } else {
                    $livros = Livros::offset($pagina)->limit(8)->get();
                }
                $livrosTotais = Livros::all();
            }
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
        }
        if (!empty($paginas) || $pagina !== null) {

            return response()->json([
                'sucesso' => true,
                'dados' => $livros,
                'meta' => [
                    'total' => count($livros),
                    'pagina' => $pagina,
                    'porPagina' => 8,
                    'totalPaginas' => round(count($livrosTotais) / 8)
                ]
            ], 200);
        } else {
            return response()->json([
                'sucesso' => true,
                'dados' => $livros
            ], 200);
        }
    }

    public function listarLivroPorId($livroId)
    {

        if (empty($livroId)) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Id do Livro não informado'
            ], 400);
        }
        $livros = Livros::where('id', $livroId)->first();

        if (empty($livros)) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Livro não encontrado'
            ], 404);
        }

        return response()->json([
            'sucesso' => true,
            'dados' => $livros
        ], 200);
    }
}
