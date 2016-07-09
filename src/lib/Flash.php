<?php
namespace csc545\lib;

/**
 * Class Flash
 *
 * Flash class enables session based form validation as well as success, warning, info, and error messages
 * by interacting with the session and setting / unsetting flash messages.
 *
 * Flash messages are meant to survive a single page transition from one page to another.
 *
 * Once a flash message is read it can no longer be read again. 
 *
 * @package csc545\lib
 */
class Flash
{
    public static $form_state = array();

    public static $form_errors = array();

    public static function hasFormState($name)
    {
        Flash::loadFormState();
        return isset(Flash::$form_state[$name]);
    }

    public static function getFormState($name)
    {
        Flash::loadFormState();
        if(isset(Flash::$form_state[$name])){
            return Flash::$form_state[$name];
        }else{
            return "";
        }
    }

    public static function hasFormError($name)
    {
        Flash::loadFormErrors();
        return in_array($name, Flash::$form_errors);
    }

    private static function loadFormState()
    {
        if(isset($_SESSION["form.state"])){
            Flash::$form_state = $_SESSION["form.state"];
            unset($_SESSION["form.state"]);
        }
    }

    private static function loadFormErrors()
    {
        if(isset($_SESSION["form.error"])){
            Flash::$form_errors = $_SESSION["form.error"];
            unset($_SESSION["form.error"]);
        }
    }

    public static function hasErrorMessages()
    {
        return isset($_SESSION["flash.error"]) && is_array($_SESSION["flash.error"]);
    }

    public static function hasSuccessMessages()
    {
        return isset($_SESSION["flash.success"]) && is_array($_SESSION["flash.success"]);
    }

    public static function hasInfoMessages()
    {
        return isset($_SESSION["flash.info"]) && is_array($_SESSION["flash.info"]);
    }

    public static function hasWarningMessages()
    {
        return isset($_SESSION["flash.warning"]) && is_array($_SESSION["flash.warning"]);
    }

    public static function flashErrorMessages()
    {
        $m = $_SESSION["flash.error"];
        unset($_SESSION["flash.error"]);
        return $m;
    }

    public static function flashSuccessMessages()
    {
        $m = $_SESSION["flash.success"];
        unset($_SESSION["flash.success"]);
        return $m;
    }

    public static function flashInfoMessages()
    {
        $m = $_SESSION["flash.info"];
        unset($_SESSION["flash.info"]);
        return $m;
    }

    public static function flashWarningMessages()
    {
        $m = $_SESSION["flash.warning"];
        unset($_SESSION["flash.warning"]);
        return $m;
    }

    public static function flashFormState()
    {
        $f = $_SESSION["form.state"];
        unset($_SESSION["form.state"]);
        return $f;
    }

    public static function addErrorMessage($m)
    {
        if(!isset($_SESSION["flash.error"]) ||!is_array($_SESSION["flash.error"])) {
            $_SESSION["flash.error"] = array($m);
        }else{
            $_SESSION["flash.error"][] = $m;
        }
    }

    public static function addSuccessMessage($m)
    {
        if(!isset($_SESSION["flash.success"]) || !is_array($_SESSION["flash.success"])) {
            $_SESSION["flash.success"] = array($m);
        }else{
            $_SESSION["flash.success"][] = $m;
        }
    }

    public static function addInfoMessage($m)
    {
        if(!isset($_SESSION["flash.info"]) || !is_array($_SESSION["flash.info"])) {
            $_SESSION["flash.info"] = array($m);
        }else{
            $_SESSION["flash.info"][] = $m;
        }
    }

    public static function addWarningMesage($m)
    {
        if(!isset($_SESSION["flash.warning"]) || !is_array($_SESSION["flash.warning"])) {
            $_SESSION["flash.warning"] = array($m);
        }else{
            $_SESSION["flash.warning"][] = $m;
        }
    }

    public static function saveFormState($form_state)
    {
        $_SESSION["form.state"] = $form_state;
    }

    public static function saveFormError($field)
    {
        if(!isset($_SESSION["form.error"])){
            $_SESSION["form.error"] = array();
        }
        $_SESSION["form.error"][] = $field;
    }

}