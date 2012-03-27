<?php
/**
 * Files required in all pages.
 * 
 * For class files required only in specific models, use $obj = $this->load('ClassName');
 * to get the ClassName instance.
 */

// General classes
require_once 'config.php';
require_once 'classes/db.class.php';
require_once 'classes/validate.class.php';
require_once 'classes/Utils.class.php';

// MVC Classes
require_once 'classes/model.class.php';
require_once 'classes/controller.class.php';


// Project specific classes
require_once 'classes/user.class.php';