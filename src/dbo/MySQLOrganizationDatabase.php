<?php

namespace csc545\dbo;

use csc545\lib\MySQLObjectIterator;
use DateTime;
use PDO;

class MySQLOrganizationDatabase extends PDO implements OrganizationInterface
{

    public function __construct()
    {
        parent::__construct(MYSQLDSN, MYSQLUSER, MYSQLPASS);
    }

    public function getJobTitles()
    {
        $query = "select job_title_id, job_title as job_title_text from job_title;";
        $stm = $this->prepare($query);
        $stm->execute();
        return new MySQLObjectIterator($stm, "JobTitle");
    }

    public function getAllNamesAndIds()
    {
        $query = "
            select organization_id as org_id, organization_name from organization
        ";
        $stm = $this->prepare($query);
        $stm->execute();
        return new MySQLObjectIterator($stm, "Organization");
    }

    public function getAllTypes()
    {
        $query = "SELECT organization_type_id as type_id, organization_type as type from organization_type";
        $stm = $this->prepare($query);
        $stm->execute();
        return new MySQLObjectIterator($stm, "OrganizationType");
    }

    public function getOrganizations(OrganizationType $type_query = null)
    {
        $query = "
        SELECT 
            o.organization_id as org_id, 
            o.*,
            count(po.organization_id) as person_count
        from 
            organization o
        left join 
            person_organization po on o.organization_id = po.organization_id
        
	    ";
        if($type_query != null){
            $query .= " where organization_type_id = ?";
        }
        $query .= "
        group by
            o.organization_id;
            ";
        $stm = $this->prepare($query);
        if($type_query != null){
            $stm->execute(array($type_query->type_id));
        }else {
            $stm->execute();
        }
        return new MySQLObjectIterator($stm, "Organization");
    }

    public function getPeople(Organization $o)
    {
        $query = "
        select
            p.person_id,
            p.last_name,	
            p.first_name,
            p.full_name
        FROM 
            organization o            
        join
            person_organization po on o.organization_id = po.organization_id
        join
            person p on po.person_id = p.person_id
        where 
            o.organization_id = ?;                
        ";

        $stm = $this->prepare($query);
        $stm->execute(array($o->org_id));
        return new MySQLObjectIterator($stm, "Person");
    }

    /**
     * @param Organization $o
     * @return mixed
     */
    public function getOrganizationRecord(Organization $o)
    {
        $query = "
            SELECT     
                o.organization_id as org_id,
                o.*,
                ot.*,
                p.*,
                po.*,
                j.*
            from 
                organization o
            left join 
                person_organization po on o.organization_id = po.organization_id
            left join
                person p on po.person_id = p.person_id
            left join
                job_title j on po.job_title_id = j.job_title_id
            left join
                organization_type ot on ot.organization_type_id = o.organization_type_id
            where
                o.organization_id = ?
            order by 
                o.organization_id asc
        ";
        $stm = $this->prepare($query);
        $stm->execute(array($o->org_id));
        $organization = new Organization();
        while($result = $stm->fetch(PDO::FETCH_ASSOC)){
            if(!isset($organization->org_id)){
                $organization->org_id = $result["org_id"];
                $organization->organization_name = $result["organization_name"];
                $organization->address = $result["address"];
                $organization->notes = $result["notes"];
                $organization->type = $result["organization_type"];
                $organization->website = $result["website"];
                $organization->year_modified = $result["year_modified"];
                $organization->people = array();
            }
            if(isset($result["person_id"])){
                $p = new Person();
                $p->person_id = $result["person_id"];
                $p->first_name = $result["first_name"];
                $p->last_name = $result["last_name"];
                $p->full_name = $result["full_name"];
                $p->start_date = new DateTime($result["start_date"]);
                $p->end_date = new DateTime($result["end_date"]);
                $p->job_title = $result["job_title"];
                $organization->people[] = $p;
            }
        }
        return $organization;
    }

    /**
     * @param Person $p
     * @param Organization $o
     * @return mixed
     */
    public function removePerson(Person $p, Organization $o)
    {
        $query = "delete from person_organization where person_id = ? and organization_id = ?";
        $stm = $this->prepare($query);
        $stm->execute(array($p->person_id, $o->org_id));
    }
}