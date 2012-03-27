<?php
/**
 * Db wrapper using Singleton pattern
 * @author Saurabh
 *
 */
class Db
{
    private $connection;
    private static $instance;
    private $insert_id;
    private $result_set;
    private $num_affected_rows;


    private function __construct()
    {
        $this->connection = mysql_connect(DB_HOST, DB_USER, DB_PASS);
        if ($this->connection)
        {
            mysql_select_db(DB_NAME);
        }
    }
    
    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new Db();
        }
        return self::$instance;
    }
    
    /**
     * Insert data into the table
     * @param string $table table name
     * @param array $data data to be inserted as key=>value pairs
     * @param boolean $echo true to echo the insert query
     * 
     * @return number last_insert_id | NULL
     */
    public function insert($table, array $data, $echo = false)
    {
        $data = $this->sanitize($data);
        $fields = "".implode(", ", array_keys($data))."";
        $values = "'".implode("', '", array_values($data))."'";
        $query = "INSERT INTO `$table` ($fields) VALUES ($values)";

        $result = $this->query($query, $echo);
        if ($result)
        {
            $this->insert_id = mysql_insert_id();
            return $this->insert_id;
        }
        return null;
    }
    
    /**
     * Sanitize all members in an array. Trims and escapes special characters for use in an sql statement
     * @param array $data eg: $_POST
     * @return array
     */
    public static function sanitize($data)
    {
        foreach ($data as $key=>$value)
        {
            if (!is_array($value))
            {
                $data[$key] = trim(mysql_escape_string($value));
            }
            else
            {
                self::sanitize($value);
            }
        }
        return $data;
    }
	

    
    /**
     * Select rows from a table
     * @param string $table table name
     * @param array $required_fields Eg: array('first_name', 'last_name')
     * @param array $conditions conditions as key=>value pairs Eg: array('id'=>'100')
     * @param number $start
     * @param number $limit
     * @param string $extra_params Eg: ORDER BY rank DESC
     * @param boolean $echo Echo the query
     */
    public function select($table, array $required_fields = null, array $conditions = null, $start = null, $limit = null, $extra_params = null, $echo = false)
    {
        $fields = " * ";
        $condn = " 1 ";
        $limit_condn = "";
        $result_array = array();
        
        if ($required_fields)
        {
            $fields = "".implode(", ", $required_fields)."";
        }
        
        if (is_array($conditions))
        {
            foreach ($conditions as $key=>$value)
            {
                $condn .= " AND $key='$value'";
            }
        }
        
        if ($start && is_numeric($start) && $limit && is_numeric($limit))
        {
            $limit_condn = " LIMIT $start, $limit ";
        }
        elseif ($limit && is_numeric($limit))
        {
            $limit_condn = " LIMIT $limit ";
        }
        
        $query = "SELECT {$fields} FROM `{$table}` WHERE {$condn} {$extra_params} {$limit_condn}";
        $result = $this->query($query);
        
        while ($row = mysql_fetch_assoc($result))
        {
            $result_array[] = $row;
        }
        
        if ($result_array)
        {
            $this->result_set = $result_array;
            return $this->result_set;
        }
        return null;
    }
    
    /**
     * Run a query
     * @param string $sql
     * @param boolean $echo True to echo the query
     * @return resource|boolean
     */
    public function query($sql, $echo = false)
    {
        if ($echo)
        {
            echo $sql;
        }
        
        $result = mysql_query($sql);
        if ($result)
        {
            return $result;
        }
        return false;
    }
    
	
    /**
     * Update a table
     * @param string $table
     * @param array $data
     * @param string | array $conditions
     * @param boolean $echo
     * @return number num_affected_rows 
     */
    public function update($table, array $data = null, $conditions = null, $echo = false)
    {
        $data = $this->sanitize($data);
        $update_str = '';
        $condition_str = '';
        
        if (!$data)
        {
            return false;
        }
        
        foreach ($data as $field => $value)
        {
            $update_str .= "$field = '$value', ";
        }
        $update_str = rtrim($update_str, ", ");
        
        if (is_string($conditions) && $conditions != '')
        {
            $condition_str = " AND {$conditions} ";
        }
        elseif (is_array($conditions))
        {
            foreach ($conditions as $key=>$value)
            {
                $condition_str .= " AND $key='$value'";
            }
        }
        
        $sql = "UPDATE {$table} SET {$update_str} WHERE 1 {$condition_str}";
        $this->query($sql, $echo);
        $this->num_affected_rows = mysql_affected_rows();
        return $this->num_affected_rows;
    }
    
    
    /**
     * Delete rows from a table
     * @param string $table
     * @param string | array $conditions
     * @param boolean $echo
     * @return number num_affected_rows 
     */
    public function delete($table, $conditions = null, $echo = false)
    {
        $condition_str = '';
        if (is_string($conditions) && $conditions != '')
        {
            $condition_str = " AND {$conditions} ";
        }
        elseif (is_array($conditions))
        {
            foreach ($conditions as $field=>$value)
            {
                $condition_str .= " AND {$field} = '{$value}'";
            }
        }
        
        $sql = "DELETE FROM {$table} WHERE 1 {$condition_str}";
        $this->query($sql);
        $this->num_affected_rows = mysql_affected_rows();
        return $this->num_affected_rows;
    }
        
    public function insert_id()
    {
        return $this->insert_id;
    }
    
    public function num_affected_rows()
    {
        return $this->num_affected_rows;
    }
    
    public function result_set()
    {
        return $this->result_set;
    }
}