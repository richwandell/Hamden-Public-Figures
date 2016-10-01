<?php

namespace csc545\controllers;

use csc545\dbo\Organization;
use csc545\lib\Controller;
use csc545\lib\DBFactory;
use csc545\dbo\Person;
use csc545\lib\Debug;
use csc545\lib\Flash;
use csc545\lib\FormError;
use csc545\lib\GeneralError;
use csc545\lib\RedirectException;
use DateTime;

class PeopleController extends Controller
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
     * @route /person/info/:id
     * @param bool $args
     * @throws RedirectException
     */
    public function info($args = false)
    {
        if(!isset($args[0]) || (int)$args[0] < 1){
            $error = new GeneralError();
            $error->setErrorMessage("Invalid Person ID");
            throw new RedirectException("/overview", array($error));
        }
        //Add a css file for this page
        $this->css_files[] = "person_info.css";
        $this->js_files[] = "person_info.js";

        //Get info about this person
        $database = DBFactory::getPeopleDatabase();
        $person_query = new Person();
        $person_query->person_id = $args[0];

        //Querys return an iterator that iterates through Person objects
        $person = $database->getPersonInfoById($person_query);

        //If we have a previous form state we set the previous form state
        if(Flash::hasFormState("first_name")){
            $person->first_name = Flash::getFormState("first_name");
        }
        if(Flash::hasFormState("last_name")){
            $person->last_name = Flash::getFormState("last_name");
        }
        
        if(
            Flash::hasFormError("new_org_start_date")
            || Flash::hasFormError("organizations_select")
            || Flash::hasFormError("new_org_end_date")
        ){
            $show_new_org_row = true;
        }else{
            $show_new_org_row = false;
        }

        //Get a list or organizations for the organizations multiselect box
        $org_database = DBFactory::getOrganizationDatabase();

        //Query returns an iterator that iterates through Organization objects
        $orgs = $org_database->getAllNamesAndIds();

        //Returns an iterator that iterates through JobTitle objects
        $job_titles = $org_database->getJobTitles();

        $this->render("personinfo.php", array(
            "person" => $person,
            "organizations" => $orgs,
            "job_titles" => $job_titles,
            "show_new_org_row" => $show_new_org_row
        ));
    }

    /**
     * Form handler for the person info page form
     * @route /person/update
     * @param bool $args
     * @throws RedirectException
     */
    public function update($args = false)
    {
        $errors = array();
        $state = array();
        
        //Check csrf token first
        if (!isset($_POST["csrf_token"]) || !$this->checkCsrf($_POST["csrf_token"], "update")) {
            $error = new FormError();
            $error->setErrorMessage("Invalid CSRF Token");
            throw new RedirectException($_SERVER["HTTP_REFERER"], array($error));
        }

        $person = new Person();
        //Check for person id
        if(isset($_POST["person_id"])){
            $person->person_id = (int)$_POST["person_id"];
        }else{
            $error = new FormError();
            $error->setErrorMessage("Missing Person ID");
            $errors[] = $error;
        }

        //Check for first name field
        if(isset($_POST["first_name"]) && trim($_POST["first_name"]) != ""){
            $state["first_name"] = $_POST["first_name"];
            $person->first_name = $_POST["first_name"];
        }else{
            $error = new FormError("first_name");
            $error->setErrorMessage("Missing first name");
            $errors[] = $error;
        }

        //Check for last name field
        if(isset($_POST["last_name"]) && trim($_POST["last_name"]) != ""){
            $state["last_name"] = $_POST["last_name"];
            $person->last_name = $_POST["last_name"];
            $person->full_name = $person->first_name . " " . $person->last_name;
        }else{
            $error = new FormError("last_name");
            $error->setErrorMessage("Missing last name");
            $errors[] = $error;
        }

        //Check if we are adding this person to a new organization
        if(isset($_POST["save_new_org"]) && $_POST["save_new_org"] == 1) {
            $organization = new Organization();
            if (isset($_POST["organizations_select"])) {
                $state["organizations_select"] = $_POST["organizations_select"];
                $organization->org_id = $_POST["organizations_select"];
            }else{
                $error = new FormError("organizations_select");
                $error->setErrorMessage("Missing Organization ID");
            }

            if(isset($_POST["new_org_start_date"]) && trim($_POST["new_org_start_date"]) != ""){
                $start_date = new DateTime($_POST["new_org_start_date"]);
                $state["new_org_start_date"] = $start_date;
                $organization->person_start_date = $start_date;
            }else{
                $error = new FormError("new_org_start_date");
                $error->setErrorMessage("Missing organization start date");
                $errors[] = $error;
            }

            if(isset($_POST["new_org_end_date"]) && trim($_POST["new_org_end_date"]) != ""){
                $end_date = new DateTime($_POST["new_org_end_date"]);
                $state["new_org_end_date"] = $end_date;
                $organization->person_end_date = $end_date;
            }else{
                $error = new FormError("new_org_end_date");
                $error->setErrorMessage("Missing organization end date");
                $errors[] = $error;
            }

            if(isset($_POST["job_title"])){
                $state["job_title"] = $_POST["job_title"];
                $organization->organization_job_title_id = $_POST["job_title"];
            }else{
                $error = new FormError("job_title");
                $error->setErrorMessage("Missing job title selection");
                $errors[] = $error;
            }
            $person->organizations[] = $organization;

            if(count($errors) > 0){
                throw new RedirectException($_SERVER["HTTP_REFERER"], $errors, $state);
            }
        }

        if(count($errors) > 0) {
            //If we have form errors we throw a redirect exception which will set the error flash message
            //as well as save the form state for us
            throw new RedirectException($_SERVER["HTTP_REFERER"], $errors, $state);
        }

        $database = DBFactory::getPeopleDatabase();
        $database->UpdatePersonInfo($person);
        Flash::addSuccessMessage("Successfully updated the record for " . $person->full_name);
        if(count($person->organizations) > 0){
            Flash::addSuccessMessage("Successfully added " . $person->full_name . " to a new organization");
        }
        $this->redirect($_SERVER["HTTP_REFERER"]);

    }
    
}
