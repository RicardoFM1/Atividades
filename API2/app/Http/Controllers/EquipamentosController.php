<?php

namespace App\Http\Controllers;

use App\Models\Equipamentos;
use Laravel\Lumen\Routing\Controller;

class EquipamentosController extends Controller
{
    public function listarEquipamentos()
    {
        $equipamentos = Equipamentos::all();

        return response()->json([
            'sucesso' => true,
            'dados' => $equipamentos
        ], 200);
    }
}
