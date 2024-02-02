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
    public static function create(array $data)
    {
        $model = new static;
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
}
