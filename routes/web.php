<?php

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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/negado', function () {
    return 'Acesso negado. Você precisa estar logado para acesssar esta página.';
})->name('negado');

Route::get('/negadologin', function () {
    return 'Acesso negado. Prezado usuário, você precisa ser adm para acessar este conteúdo';
})->name('negadologin');

Route::get('/logout', function (Request $req) {
    $req->session()->flush();
    return response('Deslogado com sucesso', 200);
});

Route::get('/produtos', 'ProdutoControlador@index');

Route::post('/login', function(Request $req) {
    $login_ok = false;
    $admin = false;

    switch ($req->input('user')) {
        case 'joao':
            $login_ok = $req->input('passwd') === "senhajoao";
            $admin = true;
            break;
        case 'marcos':
            $login_ok = $req->input('passwd') === "senhamarcos";
            break;
        case 'default':
            $login_ok  = false;
    }

    if ($login_ok) {
        $login = ['user' => $req->input('user'), 'admin' => $admin];
        $req->session()->put('login', $login);
        return response("Login OK", 200);
    } else {
        $req->session()->flush();
        return response("Erro no login", 404);
    }
});
