<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function cadastro_estoque_html(Request $request)
    {
        return view('cadastro_estoque');
    }

    public function cadastrar_estoque(Request $request)
    {
        $request->validate([
            'validade' => 'required|date',
            'descricao' => 'required|string|max:255',
        ]);

        try {
            $estoque->validade = $request->validade;
            $estoque->descricao = $request->descricao;

            $estoque->save();

            return response()->json(['message' => 'Produto cadastrado com sucesso!', 'erro' => 'n'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao cadastrar produto!', 'erro' => 's', 'msg_erro' => $th->getMessage()], 500);
        }
    }

    public function ver_estoque(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:estoque,id',
        ]);

        $estoque = Estoque::find($request->id);

        if ($estoque) {
            return response()->json(['estoque' => $estoque, 'erro' => 'n'], 200);
        }

        return response()->json(['message' => 'Produto não encontrado!', 'erro' => 's'], 200);
    }

    public function listar_estoque(Request $request)
    {
        $estoque = Estoque::all();

        return response()->json(['estoque' => $estoque], 200);
    }

    public function listar_estoque_simples(Request $request)
    {
        $estoque = Estoque::select('nome', 'tipo', 'quantidade', 'validade')->get();

        return response()->json(['estoque' => $estoque], 200);
    }

    public function alterar_estoque(Request $request)
    {
        $request->validate([
            'validade' => 'required|date',
            'descricao' => 'required|string|max:255',
        ]);

        try {
            $estoque = Estoque::find($request->id);

            $estoque->validade = $request->validade;
            $estoque->descricao = $request->descricao;

            $estoque->save();

            return response()->json(['message' => 'Estoque atualizado com sucesso!', 'erro' => 'n'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao atualizar estoque!', 'erro' => 's', 'msg_erro' => $th->getMessage()], 500);
        }
    }

    public function deletar_estoque(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:estoque,id',
        ]);

        try {
            $estoque = Estoque::find($request->id);

            if (! $estoque) {
                return response()->json(['message' => 'Estoque não encontrado!', 'erro' => 's'], 404);
            }

            $estoque->delete();

            return response()->json(['message' => 'Estoque deletado com sucesso!', 'erro' => 'n'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao deletar estoque!', 'erro' => 's', 'msg_erro' => $th->getMessage()], 500);
        }
    }
}