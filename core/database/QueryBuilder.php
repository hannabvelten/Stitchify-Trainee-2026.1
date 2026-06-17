<?php

namespace App\Core\Database;

use PDO, Exception;

class QueryBuilder
{
    protected $pdo;
    protected $table;
    protected $conditions = [];
    protected $params = [];

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

    public function paginate($table, $limit, $offset, $busca = '') {
        $params = [];
        $where = '';

        if (!empty($busca)) {
            $where = " WHERE tabela_posts.titulo LIKE :busca OR tabela_posts.categoria LIKE :busca2";
            $params['busca'] = "%{$busca}%";
            $params['busca2'] = "%{$busca}%";
        }
        
        $sql = "SELECT 
                tabela_posts.*,
                tabela_usuarios.nome AS nome_autor,
                tabela_usuarios.foto AS foto_autor
            FROM tabela_posts
            INNER JOIN tabela_usuarios ON tabela_posts.autor = tabela_usuarios.id
            {$where}
            LIMIT {$limit} OFFSET {$offset}";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

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
    
    //     //DELETE FROM `tabela_usuarios` WHERE 0
    //     public function delete($table, $id)
    //     {
    //         $sql = sprintf('DELETE FROM %s WHERE %s',
    //         $table,
    //         'id = :id'
    //         );
    
    //         try {
    //             $stmt = $this->pdo->prepare($sql);
    //             $stmt->execute(compact('id'));
    
    //         } catch (Exception $e) {
    //             die($e->getMessage());
    //         }
    //     }

    public function delete($table, $id)
    {
        $sql = sprintf('DELETE FROM %s WHERE %s',
        $table,
        'id = :id',
        );

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(compact('id'));

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
                                    
                                    // public function insert($table, $parameters){
                                        //     $sql = sprintf('INSERT INTO %s (%s) VALUES (:%s)',
                                        //     $table, 
                                        //     implode(', ', array_keys($parameters)),
                                        //     implode(', :', array_keys($parameters)),
                                        //     );
                                        
                                        //     try {
                                            //         $stmt = $this->pdo->prepare($sql);
                                            //         $stmt->execute($parameters);
                                            
                                            //         return $stmt->fetchAll(PDO::FETCH_CLASS);
                                            
                                            //     } catch (Exception $e) {
                                                //         die($e->getMessage());
                                                //     }
                                                // }
                                                
                                                // UPDATE `tabela_usuarios` 
                                                // SET `id`='[value-1]',`nome`='[value-2]',`email`='[value-3]',`tipo`='[value-4]',`senha`='[value-5]',`foto`='[value-6]' WHERE 1
                                                //     public function update($table, $id, $parameters){
                                                    //         $sql = sprintf('UPDATE %s SET %s WHERE id = %s',
                                                    //         $table,
                                                    //         implode(', ', array_map(function($param){
                                                        //             return $param . ' = :' . $param;
                                                        //         }, array_keys($parameters))),
                                                        //         $id
                                                        //         );
                                                        
                                                        //         try {
                                                            //             $stmt = $this->pdo->prepare($sql);
                                                            //             $stmt->execute($parameters);
                                                            
                                                            //             return $stmt->fetchAll(PDO::FETCH_CLASS);
                                                            
                                                            //         } catch (Exception $e) {
                                                                //             die($e->getMessage());
                                                                //         }
                                                                //     }
                                                                
                                                                }