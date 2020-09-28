<?php

session_start ();

//
//
// PATHS

set_include_path (

"../class" . PATH_SEPARATOR . 
"../include" . PATH_SEPARATOR . 
"../controller" . PATH_SEPARATOR . 
"../cnn" . PATH_SEPARATOR . 
"../dao" . PATH_SEPARATOR . 
"../model" . PATH_SEPARATOR . 
"layout/menu" . PATH_SEPARATOR .
"layout". PATH_SEPARATOR .
"public" 

);

//
//
// Data base config.

date_default_timezone_set ( 'Europe/London' );

define ( "DB_URL", "localhost" ); // Data base url exp: 127.0.0.1, localhost or other IP.
define ( "DB_USER", "" ); // Data base user, you need create a user diffrent of root.
define ( "DB_PWD", "" ); // Database password.
define ( "DB_NAME", "db_project_base"); // Data base named.
define ( "DB_PORT", 3306);

define ( "USER", !empty($_SESSION ['USER'])?$_SESSION ['USER']:null ); 

//
//
// Application config.

define ( "APPLICATION_NAME", "Your App Name" ); // Data base url exp: 127.0.0.1, localhost or other IP.
define ( "APPLICATIOIN_LOGO", "public/img/logo.png");

//
//
// Check all permissions.
require_once "AccessPermission.php";

?>
