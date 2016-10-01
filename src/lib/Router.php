<?php

namespace csc545\lib;

class Router
{
    /**
     * @var string controller name that is used
     */
    public $controller;
    /**
     * @var string the method to call
     */
    public $method;
    /**
     * @var array Parameters passed into a controller
     */
    public $parameters = array();

    /**
     * Static read factory method
     */
    public static function read()
    {
        static $router = null;
        if($router == null){
            $router = new Router();
        }
        return $router;
    }

    public function __construct()
    {
        //Get PATH_INFO variable from REQUEST_URI instead of relying on server configuration
        $route = array_values(array_filter(explode("/",
            str_replace("?" . $_SERVER["QUERY_STRING"], "",
                str_replace($_SERVER["SCRIPT_NAME"], "", $_SERVER["REQUEST_URI"])
            )
        )));
        if(count($route) > 0){
            if(isset($route[0])){
                $this->controller = strtolower($route[0]);
            }
            if(isset($route[1])){
                $this->method = $route[1];
            }else{
                $this->method = "display";
                $route = array($route[0], "display");
            }
            foreach($route as $index => $param){
                if($index > 1){
                    $this->parameters[] = $param;
                }
            }
        }
    }

    public function route()
    {
        $controller_name = 'csc545\\controllers\\' . ucfirst($this->controller) . "Controller";
        if(class_exists($controller_name)) {
            $conn = new $controller_name();
            if(method_exists($conn, $this->method)) {
                $conn->{$this->method}($this->parameters);
            }else{
                header("HTTP/1.0 404 Not Found");
                include "notfound.html";
            }
        }else{
            header("HTTP/1.0 404 Not Found");
            include "notfound.html";
        }
    }
}