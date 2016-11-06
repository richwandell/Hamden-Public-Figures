<?php

use csc545\lib\Controller;

class FakeController extends Controller
{
    public $css_files = array("a", "b", "c");
    public $js_files = array("a", "b", "c");

    function renderHead()
    {
        $this->render("head.php", array(
            "css_files" => $this->css_files,
            "js_files" => $this->js_files
        ));
    }

    function doRedirect()
    {
        $this->redirect("somewhere_else");
    }

    function killDebug()
    {
        $this->_debug = false;
    }

    function getCsrf($path = false)
    {
        return $this->csrf($path);
    }

    function testCsrf($test, $method)
    {
        return $this->checkCsrf($test, $method);
    }
}