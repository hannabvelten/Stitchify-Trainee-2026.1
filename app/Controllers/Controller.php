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
    public function exibirInscrevaSe()
    {
        return view('site/inscreva-se');
    }
    public function exibirlandingPage()
    {
        return view('site/landing-page');
    }
    public function efetuaLogin()
    {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $user = App::get('database')->verificaLogin($email, $senha);

        if( $user != false){
            session_start();
            $_SESSION['id'] = $user->id;
            header('Location: /landing-page');
        }
        else{
            session_start();
            $_SESSION['mensagem-erro'] = "Usuario e/ou senha incorretos";
            header('Location: /login');
        }

    }
    public function efetuaInscricao()
    {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $confirmarSenha = $_POST['confirmarSenha'];

        if($senha != $confirmarSenha){
            session_start();
            $_SESSION['mensagem-erro'] = "As senhas não coincidem";
            header('Location: /inscreva-se');
            return;
        }

        $user = App::get('database')->verificaEmail($email);

        if($user){
            session_start();
            $_SESSION['mensagem-erro'] = "Email já cadastrado";
            header('Location: /inscreva-se');
            return;
        }

        try{
            App::get('database')->efetuaInscricao($email, $senha);
            header('Location: /login');
        }
        catch(Exception $e){
            session_start();
            $_SESSION['mensagem-erro'] = "Ocorreu um erro ao criar a conta. Tente novamente.";
            header('Location: /inscreva-se');
        }
    }
}