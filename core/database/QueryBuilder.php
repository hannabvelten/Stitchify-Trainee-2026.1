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

    public function insert($table, $parameters){
        $sql = sprintf('INSERT INTO %s (%s) VALUES (:%s)',
        $table, 
        implode(', ', array_keys($parameters)),
        implode(', :', array_keys($parameters)),
        );

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parameters);

            return $stmt->fetchAll(PDO::FETCH_CLASS);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // UPDATE `tabela_usuarios` 
    // SET `id`='[value-1]',`nome`='[value-2]',`email`='[value-3]',`tipo`='[value-4]',`senha`='[value-5]',`foto`='[value-6]' WHERE 1
    public function update($table, $id, $parameters){
        $sql = sprintf('UPDATE %s SET %s WHERE id = %s',
        $table,
        implode(', ', array_map(function($param){
            return $param . ' = :' . $param;
        }, array_keys($parameters))),
        $id
        );

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parameters);

            return $stmt->fetchAll(PDO::FETCH_CLASS);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    //DELETE FROM `tabela_usuarios` WHERE 0
    public function delete($table, $id)
    {
        $sql = sprintf('DELETE FROM %s WHERE %s',
        $table,
        'id = :id'
        );

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(compact('id'));

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}