<?php

namespace csc545\dbo;

use csc545\lib\DBFactory;
use DateTime;

class Person{
    /**
     * @var Mixed
     */
    public $person_id;
    /**
     * @var string
     */
    public $last_name;
    /**
     * @var string
     */
    public $first_name;
    /**
     * @var string
     */
    public $full_name;
    /**
     * @var array Organization
     */
    public $organizations;
    /**
     * @var DateTime If accessed through an organization, this is the persons start date with that organization
     */
    public $start_date;
    /**
     * @var DateTime If accessed through an organization, this is the persons end date with that organization
     */
    public $end_date;
    /**
     * @var String if accessed through an organization, this is the persons job title in that organization
     */
    public $job_title;

    /**
     * @param Organization $o
     * @return bool
     */
    public function isMemberOfOrganization(Organization $o)
    {
        foreach($this->organizations as $org){
            if($org->org_id == $o->org_id){
                return true;
            }
        }
        return false;
    }
}