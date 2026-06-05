<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class Controller
{

    public function index()
    {
        return view('site/index');
    }
    public function exibirLogin()
    {
        return view('site/login');
    }
    public function exibirlandingPage()
    {
        return view('site/landingpage');
    }
    public function efetuaLogin()
    {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $user = App::get('database')->verificaLogin($email, $senha);

        if( $user != false){
            session_start();
            $_SESSION['id'] = $user->id;
            header('Location: /landingpage');
        }
        else{
            session_start();
            $_SESSION['mensagem-erro'] = "Usuario e/ou senha incorretos";
            header('Location: /login');
        }

    }
}