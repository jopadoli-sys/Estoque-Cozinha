<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    public function cadastro_html(Request $request)
    {
        return view('cadastro_produto');
    }

    public function cadastrar_produtos(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'origem' => 'required|string|max:255',
            'tipo' => 'required|string|max:100',
            'quantidade' => 'required|numeric|min:0',
            'validade' => 'required|date',
            'descricao' => 'required|string|max:255',
        ]);

        try {
            $produtos = new Produtos();
            $produtos->nome = $request->nome;
            $produtos->origem = $request->origem;
            $produtos->tipo = $request->tipo;
            $produtos->quantidade = $request->quantidade;
            $produtos->validade = $request->validade;
            $produtos->descricao = $request->descricao;

            $produtos->save();

            return response()->json(['message' => 'Produto cadastrado com sucesso!', 'erro' => 'n'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao cadastrar produto!', 'erro' => 's', 'msg_erro' => $th->getMessage()], 500);
        }
    }

    public function ver_produtos(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:produtos,id',
        ]);

        $produtos = Produtos::find($request->id);

        if ($produtos) {
            return response()->json(['produtos' => $produtos, 'erro' => 'n'], 200);
        }

        return response()->json(['message' => 'Produto não encontrado!', 'erro' => 's'], 200);
    }

    public function listar_produtos(Request $request)
    {
        $produtos = Produtos::all();

        return response()->json(['produtos' => $produtos], 200);
    }

    public function listar_produtos_simples(Request $request)
    {
        $produtos = Produtos::select('nome', 'tipo', 'quantidade', 'validade')->get();

        return response()->json(['produtos' => $produtos], 200);
    }

    public function alterar_produtos(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:produtos,id',
            'nome' => 'required|string|max:255',
            'origem' => 'required|string|max:255',
            'tipo' => 'required|string|max:100',
            'quantidade' => 'required|numeric|min:0',
            'validade' => 'required|date',
            'descricao' => 'required|string|max:255',
        ]);

        try {
            $produto = Produtos::find($request->id);

            $produto->nome = $request->nome;
            $produto->origem = $request->origem;
            $produto->tipo = $request->tipo;
            $produto->quantidade = $request->quantidade;
            $produto->validade = $request->validade;
            $produto->descricao = $request->descricao;

            $produto->save();

            return response()->json(['message' => 'Produto atualizado com sucesso!', 'erro' => 'n'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao atualizar produto!', 'erro' => 's', 'msg_erro' => $th->getMessage()], 500);
        }
    }

    public function deletar_produtos(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:produtos,id',
        ]);

        try {
            $produto = Produtos::find($request->id);

            if (! $produto) {
                return response()->json(['message' => 'Produto não encontrado!', 'erro' => 's'], 404);
            }

            $produto->delete();

            return response()->json(['message' => 'Produto deletado com sucesso!', 'erro' => 'n'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao deletar produto!', 'erro' => 's', 'msg_erro' => $th->getMessage()], 500);
        }
    }
}