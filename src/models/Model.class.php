<?php

class Model extends Database
{
    protected $table;
    protected $fillable = [];
    protected $query;
    protected $bindings = [];
    public function __construct($table)
    {
        parent::__construct();
        $this->table = $table;
        $this->query = 'SELECT * FROM ' . $this->table;
    }

    public function all()
    {
        $model = $this;
        $stmt = $model->pdo->prepare('SELECT * FROM ' . $model->table);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function exists($column, $value)
    {
        $model = $this;
        $stmt = $model->pdo->prepare('SELECT * FROM ' . $model->table . ' WHERE ' . $column . ' = :value');
        $stmt->execute([':value' => $value]);
        return $stmt->rowCount() > 0;
    }
    public function select(array $columns)
    {
        $model = $this;
        $columns = implode(', ', $columns);

        $model->query = 'SELECT ' . $columns . ' FROM ' . $model->table;
        return $model;
    }
    public function where($column, $value, $operator = '=')
    {
        $model = $this;
        $column_param = str_replace('.', '_', $column);
        
        if (strpos($model->query, 'WHERE') === false) {
            $model->query .= ' WHERE ' . $column . ' ' . $operator . " :$column_param ";
        } else {
            $model->query .= ' AND ' . $column . ' ' . $operator . " :$column_param ";
        }

        $model->bindings[":$column_param"] = $value;
        return $model;
    }
    public function andWhere($column, $value, $operator = '=')
    {
        $model = $this;
        $column_param = str_replace('.', '_', $column);

        $model->query .= ' AND ' . $column . ' ' . $operator . " :$column_param ";
        $model->bindings[":$column_param"] = $value;
        return $model;
    }
    public function orWhere($column, $value, $operator = '=')
    {
        $model = $this;
        $column_param = str_replace('.', '_', $column);

        $model->query .= ' OR ' . $column . ' ' . $operator . " :$column_param ";
        $model->bindings[":$column_param"] = $value;
        return $model;
    }
    public function join($table, $first, $operator, $second)
    {
        $model = $this;
        $model->query .= ' JOIN ' . $table . ' ON ' . $first . ' ' . $operator . ' ' . $second;
        return $model;
    }
    public function leftJoin($table, $first, $operator, $second)
    {
        $model = $this;
        $model->query .= ' LEFT JOIN ' . $table . ' ON ' . $first . ' ' . $operator . ' ' . $second;
        return $model;
    }
    public function rightJoin($table, $first, $operator, $second)
    {
        $model = $this;
        $model->query .= ' RIGHT JOIN ' . $table . ' ON ' . $first . ' ' . $operator . ' ' . $second;
        return $model;
    }
    public function groupBy($column)
    {
        $model = $this;
        $model->query .= ' GROUP BY ' . $column;
        return $model;
    }
    
    public function orderBy($column, $direction = 'ASC')
    {
        $model = $this;
        $model->query .= ' ORDER BY ' . $column . ' ' . $direction;
        return $model;
    }
    public function limit($limit)
    {
        $model = $this;

        $model->query .= ' LIMIT ' . $limit;
        return $model;
    }
    public function offset($offset)
    {
        $model = $this;
        $model->query .= ' OFFSET ' . $offset;
        return $model;
    }
    public function like($column, $value)
    {
        $model = $this;
        $model->query .= ' WHERE ' . $column . ' LIKE :value';
        $model->bindings[':value'] = $value;
        return $model;
    }
    public function first()
    {
        $model = $this;
        $model->query .= ' LIMIT 1';
        // die($model->query);
        $stmt = $model->pdo->prepare($model->query);
        $stmt->execute($model->bindings);
        //clean up
        $model->query = 'SELECT * FROM ' . $model->table;
        $model->bindings = [];

        return $stmt->fetch();
    }
    public function union($model)
    {
        $this->query .= ' UNION ' . $model->query;
        $this->bindings = array_merge($this->bindings, $model->bindings);
        return $this;
    }
    public function unionAll($model)
    {
        $this->query .= ' UNION ALL ' . $model->query;
        $this->bindings = array_merge($this->bindings, $model->bindings);
        return $this;
    }

    public function get()
    {
        $model = $this;


        $stmt = $model->pdo->prepare($model->query);
        $stmt->execute($model->bindings);
        //clean up
        $model->query = 'SELECT * FROM ' . $model->table;
        $model->bindings = [];

        return $stmt->fetchAll();
    }
    public function count()
    {
        $model = $this;
        $query = 'SELECT COUNT(*) FROM ' . $model->table . substr($model->query, strlen('SELECT * FROM ' . $model->table));
        $stmt = $model->pdo->prepare($query);
        $stmt->execute($model->bindings);
        //clean up
        $model->query = 'SELECT * FROM ' . $model->table;
        $model->bindings = [];

        return $stmt->fetchColumn();
    }
    public function max($column)
    {
        $model = $this;
        $model->query = 'SELECT MAX(' . $column . ') FROM ' . $model->table . substr($model->query, strlen('SELECT * FROM ' . $model->table));
        $stmt = $model->pdo->prepare($model->query);
        $stmt->execute();
        //clean up
        $model->query = 'SELECT * FROM ' . $model->table;
        $model->bindings = [];

        return $stmt->fetchColumn();
    }
    public function find($id)
    {
        $model = $this;
        $model->query .= " WHERE id = :id";
        $model->bindings[':id'] = $id;
        $stmt = $model->pdo->prepare($model->query);
        $stmt->execute($model->bindings);
        //clean up
        $model->query = 'SELECT * FROM ' . $model->table;
        $model->bindings = [];

        return $stmt->fetch();
    }


    public function create(array $data)
    {
        $model = $this;
        //check fillable colums
        if (count($model->fillable) > 0) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $model->fillable)) {
                    unset($data[$key]);
                }
            }
        }
        $columns = implode(', ', array_keys($data));
        $values = implode(', :', array_keys($data));
        $query = 'INSERT INTO ' . $model->table . ' (' . $columns . ') VALUES (:' . $values . ')';
        $stmt = $model->pdo->prepare($query);
        $stmt->execute($data);
        //clean up
        $model->query = 'SELECT * FROM ' . $model->table;
        $model->bindings = [];
        return $stmt->rowCount();
    }
    public function update(array $data, $id)
    {
        $model = $this;
        //check fillable colums if exists
        if (count($model->fillable) > 0) {
            $data=array_intersect_key($data, array_flip($model->fillable));
        }
        $set = '';
        foreach ($data as $key => $value) {
            $set .= $key . ' = :' . $key . ', ';
        }
        $set = rtrim($set, ', ');
        $query = 'UPDATE ' . $model->table . ' SET ' . $set . ' WHERE id = :id';
        $stmt = $model->pdo->prepare($query);
        $stmt->execute($data + [':id' => $id]);
        //clean up
        $model->query = 'SELECT * FROM ' . $model->table;
        $model->bindings = [];
        return $stmt->rowCount();
    }
    public function delete()
    {
        $model = $this;
        $query = 'DELETE FROM ' . $model->table . substr($model->query, strlen('SELECT * FROM ' . $model->table));
        $stmt = $model->pdo->prepare($query);
        $stmt->execute($model->bindings);
        //clean up
        $model->query = 'SELECT * FROM ' . $model->table;
        $model->bindings = [];
        return $stmt->rowCount();
    }


}
