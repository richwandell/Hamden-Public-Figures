<?php
ini_set("display_errors", 1);
set_include_path(getcwd() . "/templates");

define("APPSTARTUPTIME", microtime(true));
//define("APPTIMING", true);

define("MODE", "MYSQL");

define("BOOTSTRAP", "loaded");

define("MYSQLDSN", "mysql:host=localhost;dbname=politics");
define("MYSQLUSER", "root");
define("MYSQLPASS", "root");

define("MONGOSERVER", "mongodb://localhost");
define("MONGODBNAME", "scotchbox");

define("SESSIONNAME", "csc545");

define("APPNAME", "Hamden Politics");
define("APPSUBNAME", "Influence Intelligence");


session_name(SESSIONNAME);
session_start();

include_once "vendor/autoload.php";
