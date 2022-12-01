@extends('app.layouts.basico')

@section('titulo', 'CLiente')

@section('conteudo')

    <div class="conteudo-pagina-2">
        <div class="titulo-pagina">

            <p>Adicionar CLiente</p>

        </div>

        <div class="menu">
            <ul>
                <li>
                    <a href="{{ route('cliente.index') }}">Voltar</a>
                </li>
                <li>
                    <a href="">Consulta</a>
                </li>
            </ul>
        </div>

        <div class="informacao-pagina">
            <div style="width: 30%; margin-left: auto; margin-right: auto;">
                @component('app.cliente._components.form_create_edit')
                @endcomponent
            </div>
        </div>
    </div>
@endsection
