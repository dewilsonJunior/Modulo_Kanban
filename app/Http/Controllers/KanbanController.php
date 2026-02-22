<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Categoria;
use App\Models\Tarefa;

class KanbanController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        $categorias = Categoria::where('user_id', $user->id)
            ->with('tarefas')
            ->orderBy('position')
            ->get();

        return view('dashboard', compact('categorias'));
    }

    public function salvarKanban(Request $request)
    {
        $user = $request->user();

        $categorias = $request->all();

        $result = DB::transaction(function () use ($categorias, $user) {

            $categoriaIdsMantidos = [];
            $tarefaIdsMantidosPorCategoria = [];

            foreach ($categorias as $cat) {
                $categoriaModel = Categoria::updateOrCreate(
                    [
                        'id' => $cat['id'] ?? null,
                        'user_id' => $user->id,
                    ],
                    [
                        'name' => $cat['name'],
                        'position' => $cat['categoriaPos'],
                    ]
                );

                $categoriaIdsMantidos[] = $categoriaModel->id;
                $tarefaIdsMantidosPorCategoria[$categoriaModel->id] = [];

                $tarefas = $cat['tarefas'] ?? [];

                foreach ($tarefas as $t) {
                    $tarefaModel = Tarefa::updateOrCreate(
                        [
                            'id' => $t['id'] ?? null,
                            'categoria_id' => $categoriaModel->id,
                        ],
                        [
                            'name' => $t['name'],
                            'position' => $t['tarefaPos'],
                        ]
                    );

                    $tarefaIdsMantidosPorCategoria[$categoriaModel->id][] = $tarefaModel->id;
                }
            }

            return [
                'ok' => true,
                'categoriaIds' => $categoriaIdsMantidos,
            ];
        });

        return response()->json($result);
    }
}
