<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ProdutoDetalheController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return 'Seja bem-vindo!';
// });

Route::get('/', [App\Http\Controllers\PrincipalController::class, 'principal'])->name('site.index')->middleware('log.acesso');
Route::get('/sobre-nos', [App\Http\Controllers\SobreNosController::class, 'sobreNos'])->name('site.sobrenos');
Route::get('/contato', [App\Http\Controllers\ContatoController::class, 'contato'])->name('site.contato');
Route::post('/contato', [App\Http\Controllers\ContatoController::class, 'salvar'])->name('site.contato');

/* Login */
Route::get('/login/{erro?}', [App\Http\Controllers\LoginController::class, 'index'])->name('site.login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'autenticar'])->name('site.login');

/* Teste */
Route::get('/teste/{p1}/{p2}', [App\Http\Controllers\TesteController::class, 'teste'])->name('site.rota1');

/* Caso a pagina não for encontrada */
Route::fallback(function () {
    echo 'A rota acessada não existe. <a href="/">Clique aqui</a> para ir para página inicial';
});

/*Area Restrita */

Route::middleware('autenticacao:padrao,visitante')->prefix('/app')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('app.home');
    Route::get('/sair',[App\Http\Controllers\LoginController::class, 'sair'])->name('app.sair');
    Route::get('/fornecedor', [App\Http\Controllers\FornecedorController::class, 'index'])->name('app.fornecedor');
    Route::post('/fornecedor/listar', [App\Http\Controllers\FornecedorController::class, 'listar'])->name('app.fornecedor.listar');
    Route::get('/fornecedor/listar', [App\Http\Controllers\FornecedorController::class, 'listar'])->name('app.fornecedor.listar');
    Route::get('/fornecedor/adicionar', [App\Http\Controllers\FornecedorController::class, 'adicionar'])->name('app.fornecedor.adicionar');
    Route::post('/fornecedor/adicionar', [App\Http\Controllers\FornecedorController::class, 'adicionar'])->name('app.fornecedor.adicionar');
    Route::get('/fornecedor/editar/{id}/{msg?}', [App\Http\Controllers\FornecedorController::class, 'editar'])->name('app.fornecedor.editar');
    Route::get('/fornecedor/excluir/{id}', [App\Http\Controllers\FornecedorController::class, 'excluir'])->name('app.fornecedor.excluir');

    //produto
    Route::resource('produto', ProdutoController::class);

    //produto detlahes
    Route::resource('produto-detalhe', ProdutoDetalheController::class);

    Route::resource('cliente', ClienteController::class);
    Route::resource('pedido', PedidoController::class);
    //Route::resource('pedido-produto', PedidoProdutoController::class);    
    Route::get('pedido-produto/create/{pedido}', [App\Http\Controllers\PedidoProdutoController::class, 'create'])->name('app.pedido-produto.create');
    Route::post('pedido-produto/store/{pedido}', [App\Http\Controllers\PedidoProdutoController::class, 'store'])->name('app.pedido-produto.store');
    //Route::delete('pedido-produto/destroy/{pedido}/{produto}', [App\Http\Controllers\PedidoProdutoController::class, 'destroy'])->name('app.pedido-produto.destroy');
    Route::delete('pedido-produto/destroy/{pedidoProduto}/{pedido_id}', [App\Http\Controllers\PedidoProdutoController::class, 'destroy'])->name('app.pedido-produto.destroy');

});
