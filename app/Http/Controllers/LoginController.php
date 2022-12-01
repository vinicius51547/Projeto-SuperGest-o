<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request)
    {

        $erro = '';
        if ($request->get('erro') == 1) {
            $erro = 'Usuário ou senha não existe';
        }
        if ($request->get('erro') == 2) {
            $erro = 'Necessario realizar login';
        }

        return view('site.login', ['titulo' => 'Login', 'erro' => $erro]);
    }

    public function autenticar(Request $request)
    {
        //regras de validação
        $regras = [
            'usuario' => 'email',
            'senha' => 'required'
        ];

        //mensagens de feedback dee validação
        $feedback = [
            'usuario.email' => 'O campo usuário (e-mail) é obrigatório',
            'senha.required' => 'Ocampo senha é obrigatório'
        ];

        //se não passar pelo validade
        $request->validate($regras, $feedback);

        //recuperando os parametros do usuario
        $email = $request->get('usuario');
        $password = $request->get('senha');

        //iniciar o model user
        $user = new User();

        $usuario = $user
            ->where('email', $email)
            ->where('password', $password)
            ->get()
            ->first();

        if (isset($usuario->name)) {
            session_start();
            $_SESSION['nome'] = $usuario->name;
            $_SESSION['email'] = $usuario->email;

            return redirect()->route('app.home');
        } else {
            return redirect()->route('site.login', ['erro' => 1]);
        }
    }

    public function sair() {
        session_destroy();
        return redirect()->route('site.index');
    }
}
