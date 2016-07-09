<?php

namespace csc545\lib;

class Debug{

    private static $debug = array();

    private static $redirect = false;

    public function __construct()
    {
        if(isset($_SESSION["debug.redirect"])){
            Debug::$debug = $_SESSION["debug.redirect"];
            unset($_SESSION["debug.redirect"]);
        }
    }

    /**
     * Add a debug message or object to the debug static property
     * @param $things
     */
    public static function debug($things)
    {
        Debug::$debug[] = $things;
    }

    public static function setRedirectMode($mode = true)
    {
        Debug::$redirect = $mode;
    }

    /**
     * Destruct magic method outputs a debug section at the bottom of the app if we have debug objects set
     * in the static Debug::$debug array
     *
     * Debug uses a <pre> tag, loops through debug objects and outputs them using print_r function then outputs a
     * newline to seperate any strings
     */
    public function __destruct()
    {
        if(Debug::$redirect){
            $_SESSION["debug.redirect"] = Debug::$debug;
        }
        if(defined("APPTIMING") && APPTIMING == true){
            $t = microtime(true);
            Debug::debug(PHP_EOL . "Start time: " . APPSTARTUPTIME . PHP_EOL . "End Time: " . $t . PHP_EOL . "Total Application Time: " . ($t - APPSTARTUPTIME));
        }
        if(count(Debug::$debug) > 0) {
            echo "<pre class='alert-info csc545-debug-pre'>";
            $num = 0;
            foreach (Debug::$debug as $db) {
                //Output a new line with line number
                echo "
[debug] $num: ";
                //Output the debug object
                print_r($db);
                $num++;
            }
            echo "</pre>";
        }
    }
}