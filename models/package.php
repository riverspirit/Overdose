<?php

class Package_model extends Model
{
    public function index()
    {
        $package = $this->load('Package');
        
        $msg = "In index() function!\n";
        $arr = $package;
        return array('msg' => $msg, 'arr' => $arr);
    }
    
    public function test()
    {
        echo "test() called!";
    }
}