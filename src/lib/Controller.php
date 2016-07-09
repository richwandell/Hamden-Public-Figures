<?php

namespace csc545\lib;

/**
 * Class Controller
 *
 * Contains standard methods used on all pages in the app.
 *
 * @package csc545\lib
 */
class Controller{

    public function __construct()
    {
        $this->_debug = new Debug();
    }

    /**
     * Test a csrf token,
     * Requires the test token and the method that the token was generated for
     * @param $test
     * @param $method
     * @return bool
     */
    protected function checkCsrf($test, $method)
    {
        return $test == $_SESSION["csrf_" . $method];
    }

    /**
     * Generate a csrf token
     */
    protected function csrf($path = false)
    {
        $router = Router::read();
        $path = $path == false ? $router->method : $path;
        $csrf = md5(rand());
        $_SESSION["csrf_" . $path] = $csrf;
        return $csrf;
    }
    /**
     * Renders a template using the args passed into it
     * @param $template
     * @param $args
     */
    protected function render($template, $args = array())
    {
        extract($args);
        unset($args);
        include_once $template;
    }

    protected function redirect($to)
    {
        Debug::setRedirectMode();
        header("Location: $to");
    }
}