<?php

namespace csc545\controllers;

use csc545\dbo\Organization;
use csc545\dbo\OrganizationType;
use csc545\lib\Controller;
use csc545\lib\DBFactory;
use csc545\lib\Debug;


class OverviewController extends Controller{
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
        "overview.js"
    );

    /**
     * Display methods are the default route for a controller
     * @route /overview
     * @param bool $args
     */
    public function display($args = false)
    {
        //Using factory pattern to abstract the database layer
        $database = DBFactory::getOrganizationDatabase();

        $org_types = $database->getAllTypes();
        $all_type = new OrganizationType();
        $all_type->type_id = -1;
        $all_type->type = "All Types";

        if(isset($_GET["type"]) && $_GET["type"] != -1){
            $selected_type = new OrganizationType();
            $selected_type->type_id = $_GET["type"];
            $all_orgs = $database->getOrganizations($selected_type);
        }else{
            $selected_type = new OrganizationType();
            $selected_type->type_id = -1;
            $all_orgs = $database->getOrganizations();
        }

        if(isset($_GET["org"])){
            $selected_org = new Organization();
            $selected_org->org_id = $_GET["org"];
            $people_in_org = $database->getPeople($selected_org);
        }else{
            $selected_org = new Organization();
            $selected_org->org_id = -1;
            $people_in_org = null;
        }

        $this->render("main.php", array(
            "all_type" => $all_type,
            "organization_types" => $org_types,
            "organizations" => $all_orgs,
            "selected_type" => $selected_type,
            "selected_org" => $selected_org,
            "people_in_org" => $people_in_org
        ));
    }
}
