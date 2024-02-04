<?php

class Model extends Database
{
    protected $table;

    protected $fillable = [];
    public function __construct()
    {
        parent::__construct();
    }
    public static function find($id)
    {
        $model = new static;
        $stmt = $model->pdo->prepare('SELECT * FROM ' . $model->table . ' WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $res = $stmt->fetch();
        return $res;
    }
    public static function all()
    {
        $model = new static;
        $stmt = $model->pdo->prepare('SELECT * FROM ' . $model->table);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }
    public static function get($limit, $offset)
    {
        $model = new static;
        $stmt = $model->pdo->prepare('SELECT * FROM ' . $model->table . ' LIMIT :limit OFFSET :offset');
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }
    public static function join($table, $foreign_key, $local_key, $columns = '*')
    {
        $model = new static;
        $stmt = $model->pdo->prepare('SELECT ' . $columns . ' FROM ' . $model->table . ' JOIN ' . $table . ' ON ' . $model->table . '.' . $local_key . ' = ' . $table . '.' . $foreign_key); 
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }

    public static function create(array $data)
    {
        $model = new static;
        // check if the data keys are in the fillable array
        foreach ($data as $key => $value) {
            if (!in_array($key, $model->fillable)) {
                return false;
            }
        }
        $keys = array_keys($data);
        $keys = implode(',', $keys);
        $values = array_values($data);
        $values = implode("','", $values);
        $values = "'" . $values . "'";
        $stmt = $model->pdo->prepare('INSERT INTO ' . $model->table . ' (' . $keys . ') VALUES (' . $values . ')');
        $res = $stmt->execute();
        return $res;
    }
    public static function update(array $data, $id)
    {
        $model = new static;
        $keys = array_keys($data);
        $values = array_values($data);
        $values = implode("','", $values);
        $values = "'" . $values . "'";
        $stmt = $model->pdo->prepare('UPDATE ' . $model->table . ' SET ' . $keys[0] . ' = ' . $values . ' WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $res = $stmt->execute();
        return $res;
    }
    public static function delete($id)
    {
        $model = new static;
        $stmt = $model->pdo->prepare('DELETE FROM ' . $model->table . ' WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $res = $stmt->execute();
        return $res;
    }
    public static function where(array $data, $operator = 'AND')
    {
        // ['id' => 1, 'username' => 'admin']
        $model = new static;
        $where = '';
        // id = :id AND username = :username
        foreach ($data as $key => $value) {
            $where .= $key . ' = :' . $key . ' ' . $operator . ' ';
        }
        // id = :id AND username = :username AND
        $where = rtrim($where, ' ' . $operator . ' ');
        // id = :id AND username = :username
        $stmt = $model->pdo->prepare('SELECT * FROM ' . $model->table . ' WHERE ' . $where );
        
        foreach ($data as $key => $value) {
            $stmt->bindParam(':' . $key, $value);
        }
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;

    }
    public function exists($key, $value)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = :value');
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        $res = $stmt->fetch();
        return $res;
    }
}
