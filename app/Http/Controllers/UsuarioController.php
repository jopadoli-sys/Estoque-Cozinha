<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function cadastro_html(Request $request)
    {
        return view('cadastro_usuario');
    }

    public function cadastrar_usuarios(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:usuario',
            'data_nascimento' => 'required',
            'email' => 'required|string|email|max:255|unique:usuario,email',
            'senha' => 'required|string',
          
        ]);

        try {
            $usuario = new Usuario();
            $usuario->nome = $request->nome;
            $usuario->cpf = $request->cpf;
            $usuario->data_nascimento = $request->data_nascimento;
            $usuario->email = $request->email;
            $usuario->senha = Hash::make($request->senha);

            $usuario->save();

            return response()->json(['message' => 'Usuário cadastrado com sucesso!', 'erro' => 'n'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao cadastrar usuário!', 'erro' => 's', 'msg_erro' => $th->getMessage()], 500);
        }
    }

    public function ver_usuarios(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $usuario = Usuario::find($request->id);
        $usuario ->funcionario;

        if ($usuario) {
            return response()->json(['usuario' => $usuario, 'erro' => 'n'], 200);
        }

        return response()->json(['message' => 'Usuário não encontrado!', 'erro' => 's'], 200);
    }

    public function listar_usuarios(Request $request)
    {
        $usuarios = Usuario::all();

        return response()->json(['usuarios' => $usuarios], 200);
    }

    public function listar_usuarios_simples(Request $request)
    {
        $usuarios = Usuario::select('nome', 'email')->get();

        return response()->json(['usuarios' => $usuarios], 200);
    }

    public function alterar_usuarios(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:usuario,id',
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255', 
            'senha' => 'required|string',
            'cpf' => 'required|string|max:14|min:11',
            'data_nascimento' => 'required'
        ]);

        try {
            $usuario = Usuario::find($request->id);

            if($usuario ->cpf != $request->cpf){
                $usuario_cpf_igual = Usuario::where('cpf', $request->cpf)->first();
                if ($usuario_cpf_igual) {
                    return response()->json(['message' => 'CPF já cadastrado!', 'erro' => 's'], 400);
                }
            }
              if($usuario ->email != $request->email){
                $usuario_email_igual = Usuario::where('email', $request->email)->first();
                if ($usuario_email_igual) {
                    return response()->json(['message' => 'Email já cadastrado!', 'erro' => 's'], 400);
                }
            }

            $usuario->nome = $request->nome;
            $usuario->email = $request->email;
            $usuario->senha = Hash::make($request->senha);
            $usuario->cpf = $request->cpf;
            $usuario->data_nascimento = $request->data_nascimento;

            $usuario->save();

            return response()->json(['message' => 'Usuário atualizado com sucesso!', 'erro' => 'n'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao atualizar usuário!', 'erro' => 's', 'msg_erro' => $th->getMessage()], 500);
        }
    }


    public function deletar_usuarios(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:usuario,id',
        ]);

        try {
            $usuario = Usuario::find($request->id);
            $usuario->delete();
            return response()->json(['message' => 'Usuário deletado com sucesso!', 'erro' => 'n'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erro ao deletar usuário!', 'erro' => 's', 'msg_erro' => $th->getMessage()], 200);
        }
    }
}