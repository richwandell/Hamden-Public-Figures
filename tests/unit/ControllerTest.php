<?php
use PHPUnit\Framework\TestCase;
use csc545\lib\Debug;

include_once "FakeController.php";

class ControllerTest extends TestCase
{
    /**
     * @var FakeController
     */
    public $cont;

    public function setUp()
    {
        $_SERVER["QUERY_STRING"] = "";
        $_SERVER["REQUEST_URI"] = "/overview";
        $_SERVER["SCRIPT_NAME"] = "/index.php";
        $this->cont = new FakeController();
    }

    public function testCsrf()
    {
        $csrf = $this->cont->getCsrf();
        $this->assertEquals($csrf, $_SESSION["csrf_display"]);

        $this->assertTrue($this->cont->testCsrf($csrf, "display"));
        $this->assertFalse($this->cont->testCsrf("abcde", "display"));
        $this->assertFalse($this->cont->testCsrf($csrf, "info"));
    }


    public function testDebug()
    {
        $this->assertInstanceOf('csc545\lib\Debug', $this->cont->_debug);
        Debug::debug(array("some" => "thing"));
        ob_start();
        $this->cont->killDebug();
        Debug::clearDebug();
        $out = ob_get_clean();
        preg_match_all('/<(pre)[ \w=\'-]*>.*\n.*\n.*\n.*\[(some)\] \=\> (thing).*\n.*\n<\/\1>/', $out, $m);
        $this->assertCount(4, $m);
        $this->assertEquals($m[2][0], "some");
        $this->assertEquals($m[3][0], "thing");
    }

    /**
     * @depends testDebug
     */
    public function testDebugRedirect()
    {
        $this->cont = new FakeController();
        $this->assertInstanceOf('csc545\lib\Debug', $this->cont->_debug);
        Debug::debug(array("some" => "thing"));
        Debug::setRedirectMode(true);
        ob_start();
        $this->cont->killDebug();
        Debug::clearDebug();
        ob_get_clean();

        $this->cont = new FakeController();
        ob_start();
        $this->cont->killDebug();
        Debug::clearDebug();
        $out = ob_get_clean();
        preg_match_all('/<(pre)[ \w=\'-]*>.*\n.*\n.*\n.*\[(some)\] \=\> (thing).*\n.*\n<\/\1>/', $out, $m);
        $this->assertCount(4, $m);
        $this->assertEquals($m[2][0], "some");
        $this->assertEquals($m[3][0], "thing");
    }

    /**
     * @runInSeparateProcess
     * @depends testDebugRedirect
     */
    public function testDebugAppTiming()
    {
        define("APPTIMING", true);
        $this->assertInstanceOf('csc545\lib\Debug', $this->cont->_debug);
        ob_start();
        $this->cont->killDebug();
        Debug::clearDebug();
        $out = ob_get_clean();
        preg_match_all('/<(pre)[ \w=\'-]*>.*\n(.*)\n(.*)\n(.*)\n(.*)/', $out, $m);
        $this->assertCount(6, $m);
        $this->assertContains("Start time:", $m[3][0]);
        $this->assertContains("End Time:", $m[4][0]);
        $this->assertContains("Total Application Time:", $m[5][0]);
    }

    /**
     * @runInSeparateProcess
     */
    public function testRedirect()
    {
        $this->cont->doRedirect();
        $list = xdebug_get_headers();
        $filtered = array_values(preg_grep('/Location: somewhere_else/', $list));
        $this->assertCount(1, $filtered);
        $this->assertEquals($filtered[0], 'Location: somewhere_else');
    }

    public function testRender()
    {
        ob_start();
        $this->cont->renderHead();
        $rendered = ob_get_clean();

        preg_match_all('/<([a-z]*)\b/', $rendered, $m);
        $this->assertCount(2, $m);
        $this->assertCount(8, $m[0]);
        $this->assertCount(8, $m[1]);
        $this->assertEquals("<head", $m[0][0]);

        preg_match_all('/<link[ a-z=\"]*\/[a-z]*\/([a-z\.]*)/', $rendered, $m);
        $this->assertCount(2, $m);
        $this->assertCount(4, $m[0]);
        $this->assertCount(4, $m[1]);
        $this->assertEquals($m[1][0], "global.css");
        $this->assertEquals($m[1][1], "a");
        $this->assertEquals($m[1][2], "b");
        $this->assertEquals($m[1][3], "c");

        preg_match_all('/<script[ a-z=\"]*\/[a-z]*\/([a-z\.]*)/', $rendered, $m);
        $this->assertCount(2, $m);
        $this->assertCount(3, $m[0]);
        $this->assertCount(3, $m[1]);
        $this->assertEquals($m[1][0], "a");
        $this->assertEquals($m[1][1], "b");
        $this->assertEquals($m[1][2], "c");
    }
}