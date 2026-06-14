<?php

namespace App\Core\Database;

use PDO, Exception;

class QueryBuilder
{
    protected $pdo;


    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function selectAll($table)
    {
        $sql = "select * from {$table}";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

     public function verificaLogin($email, $senha)
    {
        $sql = sprintf('SELECT * FROM tabela_usuarios WHERE email = :email AND senha = :senha ');
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'email' => $email,
                'senha' => $senha
            ]);

            $user = $stmt->fetch(PDO::FETCH_OBJ);
            return $user;

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function verificaEmail($email)
    {
        $sql = sprintf('SELECT * FROM tabela_usuarios WHERE email = :email');
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'email' => $email
            ]);

            $user = $stmt->fetch(PDO::FETCH_OBJ);
            return $user;

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function efetuaInscricao($email, $senha)
    {
        $sql = sprintf('INSERT INTO tabela_usuarios (email, senha) VALUES (:email, :senha)');
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'email' => $email,
                'senha' => $senha
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}