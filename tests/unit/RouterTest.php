<?php

use csc545\lib\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testBadMethod()
    {
        $_SERVER["QUERY_STRING"] = "";
        $_SERVER["REQUEST_URI"] = "/overview/something";
        $_SERVER["SCRIPT_NAME"] = "/index.php";

        $r = new Router();
        ob_start();
        $r->route();
        $out = ob_get_clean();
        $expected = '<img src="/images/404.gif" ></img>';
        
        $this->assertEquals($out, $expected);
    }

    /**
     * @runInSeparateProcess
     */
    public function testBadController()
    {
        $_SERVER["QUERY_STRING"] = "";
        $_SERVER["REQUEST_URI"] = "/something/something";
        $_SERVER["SCRIPT_NAME"] = "/index.php";

        $r = new Router();
        ob_start();
        $r->route();
        $out = ob_get_clean();
        $expected = '<img src="/images/404.gif" ></img>';

        $this->assertEquals($out, $expected);
    }

    public function testOverview()
    {
        $_SERVER["QUERY_STRING"] = "";
        $_SERVER["REQUEST_URI"] = "/overview";
        $_SERVER["SCRIPT_NAME"] = "/index.php";

        $r = new Router();
        $this->assertEquals($r->controller, "overview");
        $this->assertEquals($r->method, "display");
    }

    public function testHasMethod()
    {
        $_SERVER["QUERY_STRING"] = "";
        $_SERVER["REQUEST_URI"] = "/organization/info/1";
        $_SERVER["SCRIPT_NAME"] = "/index.php";

        $r = new Router();
        $this->assertEquals($r->controller, "organization");
        $this->assertEquals($r->method, "info");
        $this->assertCount(1, $r->parameters);
    }

    /**
     * @runInSeparateProcess
     */
    public function testRouteOrgInfo()
    {
        $_SERVER["QUERY_STRING"] = "";
        $_SERVER["REQUEST_URI"] = "/organization/info/1";
        $_SERVER["SCRIPT_NAME"] = "/index.php";

        $r = new Router();
        ob_start();
        $r->route();
        $out = ob_get_clean();
        preg_match_all("/AARP''s Experience Corps/", $out, $m);

        $this->assertCount(1, $m);
        $this->assertCount(1, $m[0]);
        $this->assertEquals("AARP''s Experience Corps", $m[0][0]);
    }
}