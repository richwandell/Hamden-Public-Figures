<?php

use csc545\lib\Flash;
use csc545\lib\FormError;
use csc545\lib\RedirectException;
use PHPUnit\Framework\TestCase;

class FlashTest extends TestCase
{
    public function setUp()
    {
        $_SERVER["HTTP_REFERER"] = "/back";
    }

    public function testSuccessMessages()
    {
        Flash::addSuccessMessage("success");
        $has = Flash::hasSuccessMessages();
        $this->assertTrue($has);

        Flash::addSuccessMessage("success1");
        $messages = Flash::flashSuccessMessages();
        $this->assertCount(2, $messages);
        $this->assertEquals("success", $messages[0]);
        $this->assertEquals("success1", $messages[1]);
    }

    public function testInfoMessages()
    {
        Flash::addInfoMessage("info");
        $has = Flash::hasInfoMessages();
        $this->assertTrue($has);

        Flash::addInfoMessage("info1");
        $messages = Flash::flashInfoMessages();
        $this->assertCount(2, $messages);
        $this->assertEquals("info", $messages[0]);
        $this->assertEquals("info1", $messages[1]);
    }

    public function testWarningMessages()
    {
        Flash::addWarningMesage("warning");
        $has = Flash::hasWarningMessages();
        $this->assertTrue($has);

        Flash::addWarningMesage("warning1");
        $messages = Flash::flashWarningMessages();
        $this->assertCount(2, $messages);
        $this->assertEquals("warning", $messages[0]);
        $this->assertEquals("warning1", $messages[1]);
    }

    /**
     * @runInSeparateProcess
     */
    public function testFormError()
    {
        $errors = array();
        $state = array(
            "sa" => "a",
            "sb" => "b",
            "sc" => "c"
        );

        $error = new FormError();
        $error->setErrorMessage("Invalid CSRF Token");
        $errors[] = $error;

        $error = new FormError();
        $error->setFormField("ae");
        $error->setErrorMessage("aem");
        $errors[] = $error;

        try {
            throw new RedirectException($_SERVER["HTTP_REFERER"], $errors, $state);
        }catch(RedirectException $e){}

        $this->assertEquals($state, $_SESSION["form.state"]);

        $has = Flash::hasFormError("ae");
        $this->assertTrue($has);

        $has = Flash::hasFormState("sa");
        $this->assertTrue($has);

        $state = Flash::getFormState("sa");
        $this->assertEquals($state, "a");

        $state = Flash::getFormState("ne");
        $this->assertEquals($state, "");

        $state = Flash::flashFormState();
        $this->assertCount(3, $state);

        $has = Flash::hasErrorMessages();
        $this->assertTrue($has);

        $messages = Flash::flashErrorMessages();
        $this->assertCount(2, $messages);

        $list = xdebug_get_headers();
        $filtered = array_values(preg_grep('/Location: /', $list));
        $this->assertCount(1, $filtered);
        $this->assertEquals($filtered[0], 'Location: /back');
    }
}