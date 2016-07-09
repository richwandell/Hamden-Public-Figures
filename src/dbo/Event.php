<?php

namespace csc545\dbo;

use DateTime;

class Event{
    /**
     * @var DateTime
     */
    public $date;
    /**
     * @var String
     */
    public $event_name;
    /**
     * @var Bool
     */
    public $recurring;
    /**
     * @var String
     */
    public $description;
    /**
     * @var Organization
     */
    public $organization;
    /**
     * @var array(Person)
     */
    public $people;
}

