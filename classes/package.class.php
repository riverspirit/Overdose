<?php

class Package extends Db
{
    public $id;
    public $package_info = array();
    
    public function __construct($package_id = null)
    {
        $this->id = $package_id;
        if ($this->id)
        {
            $package_info = $this->select('packages', null, array('id' => $this->id));
            if (isset ($package_info[0]))
            {
                $this->package_info = $package_info[0];
            }
        }
    }
    
    public function create_package(array $package_info)
    {
        $data['package_name'] = $package_info['package_name'];
        $data['price_per_year'] = $package_info['price_per_year'];
        $data['status'] = $package_info['status'];
        
        $insert = $this->insert('packages', $data);
        if ($insert)
        {
            $this->id = $insert;
            $this->package_info = $data;
        }
        return $this->id;
    }
    
    public function update_package(array $package_info)
    {
        $data['package_name'] = $package_info['package_name'];
        $data['price_per_year'] = $package_info['price_per_year'];
        $data['status'] = $package_info['status'];
        
        if ($this->id)
        {
            $update = $this->update('packages', $data, array('id' => $this->id));
            $this->id = $update;
            $this->package_info = $data;
        }
        else
        {
            die('No package specified');
        }
        return $this->id;
    }
    
    public function delete_package()
    {
        $delete = $this->delete('packages', array('id' => $this->id));
        if ($delete)
        {
            $this->id = null;
            $this->package_info = array();
            return true;
        }
        return false;
    }
    
    public function get_all_packages($start = null, $limit = null)
    {
        return $this->select('packages', null, null, $start, $limit, 'ORDER BY package_name');
    }
}