<?php

namespace csc545\dbo;

use DateTime;

class Organization{
    /**
     * ID's are different in mongo and mysql
     * @var Mixed
     */
    public $org_id;
    /**
     * @var String {Board|Commission}
     */
    public $type;
    /**
     * @var string
     */
    public $organization_name;
    /**
     * @var String
     */
    public $website;
    /**
     * @var Number
     */
    public $year_modified;
    /**
     * @var String
     */
    public $address;
    /**
     * @var String
     */
    public $notes;
    /**
     * @var array (People)
     */
    public $people = array();
    /**
     * @var Number
     */
    public $person_count;

    /**
     * If this organization is associated with a person, this field holds the persons start date
     * @var DateTime
     */
    public $person_start_date;
    /**
     * If this organization is associated with a person, this field holds the persons end date
     * @var DateTime
     */
    public $person_end_date;
    /**
     * @var Number
     */
    public $organization_job_title_id;
    /**
     * @var String
     */
    public $organization_job_title;
}