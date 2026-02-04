<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        // Cache::forget("catalogos:departamentos");

        $departamentos = Departamento::select('id', 'nombre')->get();
        $formularios = Formulario::limit(9)->get(['id', 'nombre']);

        return response()->json([
            'departamentos' => $departamentos,
            'formularios' => $formularios,
            'analisis' => []
        ]);
    }

    public function provincias(int $departamento)
    {
        // Cache::forget("catalogos:provincias:$departamento");
        $provincias = Provincia::where('departamento_id', $departamento)->select('id', 'departamento_id', 'nombre')->get();

        return response()->json($provincias);
    }

    public function distritos(int $provincia)
    {
        // Cache::forget("catalogos:distritos:$provincia");

        $distritos = DB::table('distritos')
                    ->where('provincia_id', $provincia)
                    ->select(
                        'id',
                        'nombre',
                        'provincia_id',
                        'codigo',
                        DB::raw('ST_AsGeoJSON(area)::json as area'),
                        DB::raw('ST_AsGeoJSON(coords)::json as coords')
                    )
                    ->get();

        return response()->json($distritos);
    }
} 