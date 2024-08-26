<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefas;

class TarefaController extends Controller
{
    public function index()
    {
        $tarefas = Tarefas::all();
        return view('tarefas', compact('tarefas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
        ]);

        $tarefa = Tarefas::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return response()->json(['success' => true, 'tarefa' => $tarefa]);
    }

    public function destroy($id)
    {
        $tarefa = Tarefas::find($id);
        if ($tarefa) {
            $tarefa->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    public function update(Request $request, $id)
    {
        $tarefa = Tarefas::find($id);
        if ($tarefa) {
            $tarefa->nome = $request->input('nome');
            $tarefa->descricao = $request->input('descricao');
            $tarefa->save();
            return response()->json(['success' => true, 'tarefa' => $tarefa]);
        }
        return response()->json(['success' => false]);
    
    }
    public function show($id)
{
    $tarefa = Tarefas::find($id);
    if ($tarefa) {
        return response()->json(['success' => true, 'tarefa' => $tarefa]);
    }
    return response()->json(['success' => false]);
}


}
