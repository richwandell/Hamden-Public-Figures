<?php
ini_set("display_errors", 1);
set_include_path(getcwd() . "/templates");

define("APPSTARTUPTIME", microtime(true));
//define("APPTIMING", true);

define("BOOTSTRAP", "loaded");

define("MODE", "MYSQL");
//define("MODE", "MONGO");

define("MYSQLDSN", "mysql:host=localhost;dbname=politics");
define("MYSQLUSER", "root");
define("MYSQLPASS", "root");

define("MONGOSERVER", "localhost");
define("MONGODBNAME", "scotchbox");

define("SESSIONNAME", "csc545");

define("APPNAME", "Hamden Politics");
define("APPSUBNAME", "Influence Intelligence");




session_name(SESSIONNAME);
session_start();
spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'csc545\\';

    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/src/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

