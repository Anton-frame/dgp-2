<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    public function index()
    {
    $formularios = Formulario::limit(9)->get();
        return response()->json([
            'list' => $formularios,
        ]); 


    }

    public function show(Formulario $formulario)
    {
        return $formulario;
    }
}
