<?php

class Controller
{
    private $action;
    private $model;
    private $caller;
    public $model_response;
    
    public function __construct($caller)
    {
        $this->action = isset($_REQUEST['action'])? $_REQUEST['action']: 'index';
        $caller = basename($caller, '.php');
        $model_class = ucfirst($caller).'_model';
        $model_class_file = $caller.'.php';
        $this->caller = $caller;
        
        if (file_exists(MODEL_DIR.DIRECTORY_SEPARATOR.$model_class_file))
        {
            require_once MODEL_DIR.DIRECTORY_SEPARATOR.$model_class_file;
        }
        else
        {
            die(MODEL_DIR.DIRECTORY_SEPARATOR.$model_class_file.' does not exist.');
        }
        
        if (!class_exists($model_class))
        {
            die('Class ' .$model_class.' not defined in ' .MODEL_DIR.DIRECTORY_SEPARATOR.$model_class_file);
        }
        

        
        $model = new $model_class;
        if ($this->action)
        {
            if (function_exists($this->action))
            {
                call_user_func($this->action); // Override the call to $model->$action if $action is defined in controller
            }
            elseif (method_exists($model, $this->action))
            {
                $this->model_response = call_user_func(array($model, $this->action));
                $this->call_view();
            }
            else
            {
                echo "The requested method doesn't exit";
            }
        }
        
    }
    
    
    public function call_view($template = null)
    {
        if (!$template)
        {
            $template = $this->caller;
        }
        
        $template_file = TEMPLATE_DIR.DIRECTORY_SEPARATOR.$template.'.tpl.php';
        
        if (file_exists($template_file))
        {
            $_data = $this->model_response;
            $_action = $this->action;
            require_once $template_file;
        }
        else
        {
            die($template_file. ' does not exist.');
        }
    }
}