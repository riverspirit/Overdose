<?php

class User extends Db
{
    private $user_id;
    public $user_data;
    
    public function __construct($user_id = null)
    {
        $this->user_id = $user_id;
        $this->get_user_details();
    }
    
    public function get_user_id()
    {
        return $this->user_id;
    }
    
    public function get_user_details()
    {
        if (!$this->user_id)
        {
            return null;
        }
        $this->user_data = current($this->select('users', null, array('id' => $this->user_id)));
        return $this->user_data;
    }
    
    public function get_all_users($status = null, $start = null, $limit = null)
    {
        if ($status)
        {
            return $this->select('users', null, array('status' => $status), $start, $limit, 'ORDER BY name');
        }
        return $this->select('users', null, null, $start, $limit, 'ORDER BY name');
    }
    
    public function delete_user($user_id = null)
    {
        return $this->delete('users', array('id' => $this->user_id));
    }
    
    public function create_user(array $user_data)
    {
        $insert_id = $this->insert('users', $user_data);
        $this->user_id = $insert_id? $insert_id: null;
        return $this->user_id;
    }
    
    public function update_user($user_data)
    {
        if (isset($user_data['name']))
        {
            $update_array['name'] = $user_data['name'];
        }
        
        if (isset($user_data['email']))
        {
            $update_array['email'] = $user_data['email'];
        }
        
        if (isset($user_data['country']))
        {
            $update_array['country'] = $user_data['country'];
        }
        
        if (isset($user_data['status']))
        {
            $update_array['status'] = $user_data['status'];
        }
        
        if (isset($user_data['remarks']))
        {
            $update_array['remarks'] = $user_data['remarks'];
        }
        
        return $this->update('users', $update_array, array('id' => $this->user_id));
    }
}