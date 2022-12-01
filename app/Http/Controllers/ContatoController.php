<?php

namespace App\Http\Controllers;

use App\Models\SiteContato;
use Illuminate\Http\Request;
use App\Models\MotivoContato;

class ContatoController extends Controller
{
    public function contato(Request $request)
    {

        $motivo_contatos = MotivoContato::all();

        return view('site.contato', ['titulo' => 'Contato (teste)', 'motivo_contatos' => $motivo_contatos]);
    }

    public function salvar(Request $request)
    {

        //realizar a validação dos dados do formulário recebidos no request
        $regras =
            [
                'nome' => 'required|min:3|max:40',
                'telefone' => 'required',
                'email' => 'email',
                'motivo_contatos_id' => 'required',
                'mensagem' => 'required|max:2000'
            ];

        $feedback =
            [
                'nome.min' => 'O campo nome precisa ter no minimo 3 caracteres',
                'nome.max' => 'O campo nome precisa ter no maximo 40 caracteres',
                'email.email' => 'O email informado não é válido',
                'mensagem.max' => 'A mensagem teve ter no maximo 2000 caracteres',
                'required' => 'O campo :attribute precisa ser preenchido'
            ];


        $request->validate($regras, $feedback);
        
        SiteContato::create($request->all());
        return redirect()->route('site.index');
    }
}
