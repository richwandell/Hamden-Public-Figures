<?php
use csc545\controllers\PeopleController;
use csc545\lib\RedirectException;
use PHPUnit\Framework\TestCase;

class DBFactory {

    static function getPeopleDatabase()
    {
        $db = new stdClass();
        $db->UpdatePersonInfo = function($obj){};
        return $db;
    }

}


class PeopleControllerTest extends TestCase
{
    /**
     * @var PeopleController
     */
    public $cont;

    public function setUp()
    {
        $_SERVER["QUERY_STRING"] = "";
        $_SERVER["REQUEST_URI"] = "/people/update/1";
        $_SERVER["SCRIPT_NAME"] = "/index.php";
        $_SERVER["HTTP_REFERER"] = "/back";
        $this->cont = new PeopleController();
    }

    /**
     * @runInSeparateProcess
     */
    public function testChecksForCsrf()
    {
        $this->expectException(RedirectException::class);
        $this->cont->update();
    }

    /**
     * @runInSeparateProcess
     */
    public function testAllErrors()
    {
        $_POST["csrf_token"] = "abcde";
        $_SESSION["csrf_update"] = "abcde";
        try {
            $this->cont->update();
        } catch (RedirectException $e) {
            $this->assertArrayHasKey("form.error", $_SESSION);
        }
    }

    /**
     * @runInSeparateProcess
     */
    public function testUpdateWorks()
    {
        $_POST["first_name"] = "Rich";
        $_POST["last_name"] = "Wandell";
        $_POST["person_id"] = 1;
        $_POST["csrf_token"] = "abcde";
        $_SESSION["csrf_update"] = "abcde";

        $this->cont->update();
    }

    /**
     * @runInSeparateProcess
     */
    public function testSaveNewOrgErrors()
    {
        $_POST["save_new_org"] = 1;
        $_POST["first_name"] = "Rich";
        $_POST["last_name"] = "Wandell";
        $_POST["person_id"] = 1;
        $_POST["csrf_token"] = "abcde";
        $_SESSION["csrf_update"] = "abcde";

        try {
            $this->cont->update();
        } catch (RedirectException $e) {
            $this->assertArrayHasKey("form.error", $_SESSION);
            $this->assertCount(3, $_SESSION["form.error"]);
        }
    }

    /**
     * @runInSeparateProcess
     */
    public function testSaveNewOrgWorks()
    {
        $_POST["job_title"] = 1;
        $_POST["new_org_end_date"] = date('Y-m-d H:i:s');
        $_POST["new_org_start_date"] = date('Y-m-d H:i:s');
        $_POST["organizations_select"] = 1;
        $_POST["save_new_org"] = 1;
        $_POST["first_name"] = "Rich";
        $_POST["last_name"] = "Wandell";
        $_POST["person_id"] = 1;
        $_POST["csrf_token"] = "abcde";
        $_SESSION["csrf_update"] = "abcde";


        $this->cont->update();

    }
}