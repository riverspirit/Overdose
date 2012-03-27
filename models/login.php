<?php

class Login_model extends Model
{
    public function index()
    {
        return;
    }
    
    public function loginSubmit()
    {
        $login = $this->db->select('admin_users', null, array('username'=>$_POST['username']
                                                            , 'password'=>md5($_POST['password'])
                                                            , 'status'=>1));
        if (empty ($login))
        {
            Utils::redirect('login.php', 'Authentication failed', 'error', 'login');
        }
        else
        {
            $_SESSION['admin'] = $login[0];
            $return_url = isset($_REQUEST['return'])? $_REQUEST['return']: 'admin.php';
            //print_r($_GET); die();
            Utils::redirect($return_url, 'Login success', 'success', 'login');
        }
    }
    
    public function logout()
    {
        unset ($_SESSION['admin']);
        Utils::redirect('login.php', 'Logged out', 'success', 'login');
    }
}