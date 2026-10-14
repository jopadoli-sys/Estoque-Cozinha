<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class FuncionarioController extends Controller
{
    public function cadastro_html(Request $request)
    {
        return view('cadastro_funcionario');
    }

    public function cadastrar_funcionarios(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:usuario',
            'data_nascimento' => 'required',
            'email' => 'required|string|email|max:255|unique:usuario,email',
            'nif' => 'required|string|max:255',
        ]);

        try {
            $funcionario = new Funcionario();
            $funcionario->nome = $request->nome;
            $funcionario->cpf = $request->cpf;
            $funcionario->data_nascimento = $request->data_nascimento;
            $funcionario->email = $request->email;
            $funcionario->nif = $request->nif;

            $funcionario->save();

            return response()->json(['message' => 'Funcionário cadastrado com sucesso!', 'erro' => 'n'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao cadastrar funcionário!', 'erro' => 's', 'msg_erro' => $th->getMessage()], 500);
        }
    }

    public function ver_funcionarios(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $funcionario = Funcionario::find($request->id);

        if ($funcionario) {
            return response()->json(['funcionario' => $funcionario, 'erro' => 'n'], 200);
        }

        return response()->json(['message' => 'Funcionário não encontrado!', 'erro' => 's'], 200);
    }

    public function listar_funcionarios(Request $request)
    {
        $funcionarios = Funcionario::all();

        return response()->json(['funcionarios' => $funcionarios], 200);
    }

    public function listar_funcionarios_simples(Request $request)
    {
        $funcionarios = Funcionario::select('nome', 'email')->get();

        return response()->json(['funcionarios' => $funcionarios], 200);
    }

    public function alterar_funcionarios(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:usuario,id',
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required',
            'email' => 'required|string|email|max:255',
            'cpf' => 'required|string|max:14|min:11',
        ]);

        try {
            $funcionario = Funcionario::find($request->id);

            if($funcionario ->cpf != $request->cpf){
                $funcionario_cpf_igual = Funcionario::where('cpf', $request->cpf)->first();
                if ($funcionario_cpf_igual) {
                    return response()->json(['message' => 'CPF já cadastrado!', 'erro' => 's'], 400);
                }
            }
              if($funcionario ->email != $request->email){
                $funcionario_email_igual = Funcionario::where('email', $request->email)->first();
                if ($funcionario_email_igual) {
                    return response()->json(['message' => 'Email já cadastrado!', 'erro' => 's'], 400);
                }
            }

            $funcionario->nome = $request->nome;
            $funcionario->email = $request->email;
            $funcionario->cpf = $request->cpf;
            $funcionario->data_nascimento = $request->data_nascimento;

            $funcionario->save();

            return response()->json(['message' => 'Funcionário atualizado com sucesso!', 'erro' => 'n'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao atualizar funcionário!', 'erro' => 's', 'msg_erro' => $th->getMessage()], 500);
        }
    }


    public function deletar_funcionarios(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:funcionario,id',
        ]);

        try {
            $funcionario = Funcionario::find($request->id);
            $funcionario->delete();
            return response()->json(['message' => 'Funcionário deletado com sucesso!', 'erro' => 'n'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao deletar funcionário!', 'erro' => 's', 'msg_erro' => $th->getMessage()], 200);
        }
    }
}