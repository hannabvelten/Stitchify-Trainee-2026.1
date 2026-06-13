<?php

namespace App\Core\Database;

use PDO, Exception;

class QueryBuilder
{
    protected $pdo;
    protected $table;
    protected $conditions = [];
    protected params = [];

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->conditions[] = "{$column} {$operator} :{$column}";
        $this->params[$column] = $value;
        return $this;
    }

    public function orWhere($column, $operator, $value)
    {
        $this->conditions[] = "OR {$column} {$operator} :{$column}_or";
        $this->params[$column.'_or'] = $value;
        return $this;
    }

    public function get()
    {
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(' ', $this->conditions);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params ?? []);
        return $stmt->fetchAll(PDO::FETCH_CLASS);
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

    // Como temos uma chave estrangeira(autor) na tabela_posts precisamos
    // fazer um tipo de consulta diferente no BD para poder pegar o nome
    // e a foto do autor

    public function selectAllPosts()
    {
        $sql = "SELECT 
                tabela_posts.*,
                tabela_usuarios.nome AS nome_autor,
                tabela_usuarios.foto AS foto_autor
                FROM tabela_posts
                INNER JOIN tabela_usuarios ON tabela_posts.autor = tabela_usuarios.id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function insert($table, $parameters)
    {
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

    public function countAll($table) {
        $sql = "SELECT COUNT(*) AS total FROM {$table}";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function paginate($table, $limit, $offset) {
        $sql = "SELECT 
                tabela_posts.*,
                tabela_usuarios.nome AS nome_autor,
                tabela_usuarios.foto AS foto_autor
            FROM tabela_posts
            INNER JOIN tabela_usuarios ON tabela_posts.autor = tabela_usuarios.id
            LIMIT {$limit} OFFSET {$offset}";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function findById($table, $idColumn, $id)
    {
        $sql = "SELECT * FROM {$table} WHERE {$idColumn} = :id LIMIT 1";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function update($table, $idColumn, $id, $parameters)
    {
        $setParts = [];
        foreach ($parameters as $column => $value) {
            $setParts[] = "{$column} = :{$column}";
        }

        $setString = implode(', ', $setParts);

        $sql = "UPDATE {$table} SET {$setString} WHERE {$idColumn} = :id";

        try {
            $stmt = $this->pdo->prepare($sql);

            // add id to parameters
            $parameters['id'] = $id;

            $stmt->execute($parameters);

            return $stmt->rowCount();

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function delete($table, $idColumn, $id)
    {
        $sql = "DELETE FROM {$table} WHERE {$idColumn} = :id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);

            return $stmt->rowCount();

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    //Funcao para landing page
    public function getLatest($table, $limit){
        $sql = "SELECT tabela_posts.*,
                tabela_usuarios.nome AS nome_autor,
                tabela_usuarios.foto AS foto_autor
            FROM tabela_posts
            INNER JOIN tabela_usuarios ON tabela_posts.autor = tabela_usuarios.id
            ORDER BY tabela_posts.id_post DESC
            LIMIT {$limit}";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS);

        } catch (Exception $e) {
            die($e->getMessage());
        } 
    }

    //Funcao para o Post Individual

    public function findPost($id){
        $sql = "SELECT 
                tabela_posts.*,
                tabela_usuarios.nome AS nome_autor,
                tabela_usuarios.foto AS foto_autor
            FROM tabela_posts
            INNER JOIN tabela_usuarios ON tabela_posts.autor = tabela_usuarios.id
            WHERE tabela_posts.id_post = :id
            LIMIT 1";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            die($e->getMessage());
        }
            
    }

    //Funcao para pegar os posts do autor no card do autor na página de post individual

    public function getPostsByAutor($autorId){
        $sql = "SELECT 
                    tabela_posts.*,
                    tabela_usuarios.nome AS nome_autor,
                    tabela_usuarios.foto AS foto_autor
                FROM tabela_posts
                INNER JOIN tabela_usuarios ON tabela_posts.autor = tabela_usuarios.id
                WHERE tabela_posts.autor = :autor_id
                ORDER BY tabela_posts.id_post DESC
                LIMIT 4";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['autor_id' => $autorId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    
}