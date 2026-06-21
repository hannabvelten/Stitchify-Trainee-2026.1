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

    private function montarFiltrosPosts($filtros, &$params)
    {
        $condicoes = [];
        $params = [];

        $busca = trim($filtros['busca'] ?? '');
        if ($busca !== '') {
            $condicoes[] = '(tabela_posts.titulo LIKE :busca OR tabela_posts.descricao LIKE :busca OR tabela_posts.categoria LIKE :busca OR tabela_usuarios.nome LIKE :busca)';
            $params['busca'] = "%{$busca}%";
        }

        $categoria = trim($filtros['categoria'] ?? '');
        if ($categoria !== '') {
            $condicoes[] = 'tabela_posts.categoria LIKE :categoria';
            $params['categoria'] = "%{$categoria}%";
        }

        $dataInicio = trim($filtros['data_inicio'] ?? '');
        if ($dataInicio !== '') {
            $condicoes[] = 'DATE(tabela_posts.data) >= :data_inicio';
            $params['data_inicio'] = $dataInicio;
        }

        $dataFim = trim($filtros['data_fim'] ?? '');
        if ($dataFim !== '') {
            $condicoes[] = 'DATE(tabela_posts.data) <= :data_fim';
            $params['data_fim'] = $dataFim;
        }

        if (empty($condicoes)) {
            return '';
        }

        return ' WHERE ' . implode(' AND ', $condicoes);
    }

    public function countPostsFiltrados($filtros)
    {
        $params = [];
        $where = $this->montarFiltrosPosts($filtros, $params);

        $sql = "SELECT COUNT(*) AS total
                FROM tabela_posts
                INNER JOIN tabela_usuarios ON tabela_posts.autor = tabela_usuarios.id
                {$where}";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) ($resultado['total'] ?? 0);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function paginatePostsFiltrados($limit, $offset, $filtros)
    {
        $params = [];
        $where = $this->montarFiltrosPosts($filtros, $params);

        $sql = "SELECT 
                tabela_posts.*, 
                tabela_usuarios.nome AS nome_autor, 
                tabela_usuarios.foto AS foto_autor
            FROM tabela_posts
            INNER JOIN tabela_usuarios ON tabela_posts.autor = tabela_usuarios.id
            {$where}
            LIMIT :limit OFFSET :offset";

        try {
            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $nomeParametro => $valorParametro) {
                $stmt->bindValue(':'.$nomeParametro, $valorParametro);
            }

            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS);

        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getCategoriasPosts()
    {
        $sql = "SELECT DISTINCT categoria
                FROM tabela_posts
                ORDER BY categoria ASC";

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

    public function delete($table, $columnOrId, $id = null)
    {
        if ($id === null) {
            $column = 'id';
            $id = $columnOrId;
        } else {
            $column = $columnOrId;
        }

        $sql = sprintf('DELETE FROM %s WHERE %s = :id',
            $table,
            $column
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
                ORDER BY tabela_posts.id_post DESC";

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
                    
                    public function efetuaInscricao($nome, $email, $senha, $foto)
                    {
                        $sql = sprintf('INSERT INTO tabela_usuarios (nome, email, senha, tipo, foto) VALUES (:nome, :email, :senha, :tipo, :foto)');
                        try {
                            $stmt = $this->pdo->prepare($sql);
                            $stmt->execute([
                                'nome' => $nome,
                                'email' => $email,
                                'senha' => $senha,
                                'tipo' => 'usuario',
                                'foto' => $foto
                                ]);
                                } catch (Exception $e) {
                                    throw new Exception($e->getMessage());
                                    }
                                    }
                                    
    public function paginateUsuarios($limit, $offset, $busca = '') {
        $params = [];
        $where = '';

        if (!empty($busca)) {
            $where = " WHERE nome LIKE :busca OR email LIKE :busca2";
            $params['busca'] = "%{$busca}%";
            $params['busca2'] = "%{$busca}%";
        }

        $sql = "SELECT * FROM tabela_usuarios {$where} LIMIT {$limit} OFFSET {$offset}";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function countUsuarios($busca = '')
    {
        $params = [];
        $where = '';

        if (!empty($busca)) {
            $where = " WHERE nome LIKE :busca OR email LIKE :busca2";
            $params['busca'] = "%{$busca}%";
            $params['busca2'] = "%{$busca}%";
        }

        $sql = "SELECT COUNT(*) AS total FROM tabela_usuarios {$where}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
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