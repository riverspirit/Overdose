<?php

class Model extends Db
{
    public $db;
    
    public function __construct()
    {
        $this->db = $this->getInstance();
        return;
    }
    
    public function load($class_name)
    {
        $class_file = strtolower($class_name).'.class.php';
        $class_file_full_path = CLASS_DIR.DIRECTORY_SEPARATOR.$class_file;
        if (file_exists($class_file_full_path))
        {
            require_once $class_file_full_path;
            return new $class_name;
        }
        else
        {
            die($class_file_full_path. ' does not exist.');
        }
    }
}