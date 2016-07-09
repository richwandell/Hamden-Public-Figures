<?php

namespace csc545\controllers;

use csc545\dbo\Organization;
use csc545\dbo\Person;
use csc545\lib\Controller;
use csc545\lib\DBFactory;
use csc545\lib\Debug;
use csc545\lib\Flash;
use csc545\lib\FormError;
use csc545\lib\GeneralError;
use csc545\lib\RedirectException;
use DateTime;

class OrganizationController extends Controller
{
    /**
     * @var array The css files to include
     */
    public $css_files = array(
        "bootstrap/css/bootstrap.min.css",
        "people.css"
    );

    /**
     * @var array the js files to include
     */
    public $js_files = array(
        "jquery-1.12.4.min.js",
        "bootstrap/js/bootstrap.min.js",
        "people.js"
    );

    /**
     * Displays the organization information page
     *
     * @route /person/info/:id
     * @param bool $args
     * @throws RedirectException
     */
    public function info($args = false)
    {
        if (!isset($args[0])) {
            $error = new GeneralError();
            $error->setErrorMessage("Missing Organization ID");
            throw new RedirectException("/overview", array($error));
        }
        //Add a css file for this page
        $this->css_files[] = "organization_info.css";
        $this->js_files[] = "organization_info.js";

        //Get info about this person
        $database = DBFactory::getOrganizationDatabase();
        $org = new Organization();
        $org->org_id = $args[0];

        $org = $database->getOrganizationRecord($org);

        $this->render(
            "organizationinfo.php",
            array(
                "organization" => $org
            )
        );
    }

    /**
     * Form handler for removing a person from an organization
     *
     * @router /person/removePerson
     * @param bool $args
     * @throws RedirectException
     */
    public function removePerson($args = false)
    {
        $errors = array();
        $state = array();

        //Check csrf token first
        if (!isset($_POST["csrf_token"]) || !$this->checkCsrf($_POST["csrf_token"], "removePerson")) {
            $error = new FormError();
            $error->setErrorMessage("Invalid CSRF Token");
            throw new RedirectException($_SERVER["HTTP_REFERER"], array($error));
        }
        $org = new Organization();
        $person = new Person();
        if(isset($_POST["delete_button"])){
            $person->person_id = (int)$_POST["delete_button"];
        }
        if(isset($_POST["organization_id"])){
            $org->org_id = $_POST["organization_id"];
        }
        $database = DBFactory::getOrganizationDatabase();
        $database->removePerson($person, $org);
        Flash::addSuccessMessage("Successfully removed a person from this organization");
        $this->redirect($_SERVER["HTTP_REFERER"]);
    }
}