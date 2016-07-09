<?php

namespace csc545\dbo;

use csc545\lib\Debug;
use csc545\lib\MySQLObjectIterator;
use DateTime;
use PDO;

class MySQLPeopleDatabase extends PDO implements PeopleInterface{

    public function __construct()
    {
        parent::__construct(MYSQLDSN, MYSQLUSER, MYSQLPASS);
    }
    
    public function updatePersonInfo(Person $p)
    {
        $query = "
            update person set first_name = ?, last_name = ?, full_name = ?
            where person_id = ?
        ";
        $stm = $this->prepare($query);
        $stm->execute(array(
            $p->first_name,
            $p->last_name,
            $p->first_name. " " . $p->last_name,
            $p->person_id
        ));
        if(count($p->organizations) > 0) {
            $query = "
            insert into 
                person_organization (`organization_id`, `person_id`, `start_date`, `end_date`, `job_title_id`) 
            values 
                (?, ?, ?, ?, ?)
            ";
            $stm = $this->prepare($query);
            $stm->execute(array(
                $p->organizations[0]->org_id,
                $p->person_id,
                $p->organizations[0]->person_start_date->format("Y-m-d"),
                $p->organizations[0]->person_end_date->format("Y-m-d"),
                $p->organizations[0]->organization_job_title_id
            ));
        }
    }

    public function getPersonInfoById(Person $p)
    {
        $query = "
        select 
            p.person_id,
            p.first_name,
            p.last_name,
            p.full_name,
            o.address as organization_address,
            o.organization_id,
            o.organization_name,
            o.notes as organization_notes,
            o.website,
            j.job_title_id,
            j.job_title,
            po.start_date as organization_start_date,
            po.end_date as organization_end_date
        from 
            person p
        join
            person_organization po on p.person_id = po.person_id      
        join
            organization o on po.organization_id = o.organization_id
        left join
            job_title j on po.job_title_id = j.job_title_id
        where
            p.person_id = ?";
        $stm = $this->prepare($query);
        $stm->execute(array($p->person_id));
        $person = null;
        while($dbo = $stm->fetch(PDO::FETCH_ASSOC)) {
            if($person == null) {
                $person = new Person();
                $person->person_id = $dbo["person_id"];
                $person->first_name = $dbo["first_name"];
                $person->last_name = $dbo["last_name"];
                $person->full_name = $dbo["full_name"];
                $person->organizations = array();
            }
            if (!is_null($dbo["organization_id"])) {
                $org = new Organization();
                $org->org_id = $dbo["organization_id"];
                $org->address = $dbo["organization_address"];
                $org->notes = $dbo["organization_notes"];
                $org->website = $dbo["website"];
                $org->organization_name = $dbo["organization_name"];
                $org->organization_job_title_id = $dbo["job_title_id"];
                $org->organization_job_title = $dbo["job_title"];
                $org->person_start_date = new DateTime($dbo["organization_start_date"]);
                $org->person_end_date = new DateTime($dbo["organization_end_date"]);
                $person->organizations[] = $org;
            }
        }
        return $person;
    }
}