<?php
/**
 * Require this page on top of each page which should be accessible only
 * by a logged in user
 */
if (!isset ($_SESSION['admin']))
{
    $return_url = basename($_SERVER['REQUEST_URI']);
    Utils::redirect('login.php?return='.$return_url, 'Please login to access this page', 'error', 'login');
}
