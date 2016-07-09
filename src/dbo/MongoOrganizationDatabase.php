<?php

namespace csc545\dbo;

use csc545\lib\Debug;
use csc545\lib\MongoObjectIterator;
use DateTime;
use Iterator;
use MongoClient;
use MongoDate;
use MongoException;
use MongoId;
use MongoRegex;

class MongoOrganizationDatabase extends MongoClient implements OrganizationInterface
{

    public function __construct()
    {
        parent::__construct(MONGOSERVER);
    }

    /**
     * @return Iterator
     */
    public function getJobTitles()
    {
        $coll = $this->selectCollection(MONGODBNAME, "job_titles");
        $objs = $coll->aggregateCursor(array(array(
            '$project' => array(
                "job_title_id" => '$job_title_text',
                "job_title_text" => '$job_title_text'
            )
        )));
        return new MongoObjectIterator($objs, "JobTitle");
    }

    /**
     * @return Iterator
     */
    public function getAllTypes()
    {
        $coll = $this->selectCollection(MONGODBNAME, "organizations");
        $objs = $coll->distinct("type");
        $org_types = array();

        foreach($objs as $obj){
            $org_type = new OrganizationType();
            $org_type->type = $obj;
            $org_type->type_id = $obj;
            $org_types[] = $org_type;
        }
        return $org_types;
    }

    /**
     * @param Organization $o
     * @return Iterator
     */
    public function getPeople(Organization $o)
    {
        try {
            $coll = $this->selectCollection(MONGODBNAME, "organizations");
            $objs = $coll->findOne(
                array(
                    "_id" => new MongoId($o->org_id)
                ),
                array("people" => true)
            );
            $people = array();
            foreach ($objs["people"] as $p) {
                $person = new Person();
                $person->person_id = $p["person_id"];
                $person->last_name = $p["last_name"];
                $person->first_name = $p["first_name"];
                $person->full_name = $p["full_name"];
                $person->start_date = $p["start_date"];
                $person->end_date = $p["end_date"];
                $people[] = $person;
            }
        }catch(MongoException $m){
            return array();
        }
        return $people;
    }

    /**
     * @param OrganizationType $type_query
     * @return Iterator
     */
    public function getOrganizations(OrganizationType $type_query = null)
    {
        $coll = $this->selectCollection(MONGODBNAME, "organizations");
        $query = array();
        if($type_query != null){
            $query[] = array(
                '$match' => array(
                    "type" => new MongoRegex("/$type_query->type_id/")
                )
            );
        }
        $query[] = array(
            '$project' => array(
                "org_id" => '$_id',
                "type" => '$type',
                "organization_name" => '$organization_name',
                "website" => '$website',
                "year_modified" => '$year_modified',
                "address" => '$address',
                "notes" => '$notes',
                "person_count" => array('$size' => '$people')
            )
        );
        $objs = $coll->aggregateCursor($query);
        return new MongoObjectIterator($objs, "Organization");
    }

    /**
     * @return Iterator
     */
    public function getAllNamesAndIds()
    {
        $coll = $this->selectCollection(MONGODBNAME, "organizations");
        $objs = $coll->aggregateCursor(array(
            array('$project' => array(
                "org_id" => '$_id',
                "organization_name" => '$organization_name'
            ))
        ));
        return new MongoObjectIterator($objs, "Organization");
    }

    /**
     * @param Organization $o
     * @return mixed
     */
    public function getOrganizationRecord(Organization $o)
    {
        $coll = $this->selectCollection(MONGODBNAME, "organizations");
        $org_record = $coll->findOne(array(
            "_id" => new MongoId($o->org_id)
        ));
        $org = new Organization();
        $org->org_id = $org_record["_id"];
        $org->organization_name = $org_record["organization_name"];
        $org->type  = $org_record["type"];
        $org->website = $org_record["website"];
        $org->year_modified = $org_record["year_modified"];
        $org->address = $org_record["address"];
        $org->notes = $org_record["notes"];
        foreach($org_record["people"] as $person){
            $p = new Person();
            $p->person_id = $person["person_id"];
            $p->last_name = $person["last_name"];
            $p->first_name = $person["first_name"];
            $p->full_name = $person["full_name"];
            $p->start_date = new DateTime('@' . $person["start_date"]->sec);
            $p->end_date = new DateTime('@' . $person["end_date"]->sec);
            $p->job_title = $person["job_title"];
            $org->people[] = $p;
        }
        return $org;
    }

    /**
     * @param Person $p
     * @param Organization $o
     * @return mixed
     */
    public function removePerson(Person $p, Organization $o)
    {
        $coll = $this->selectCollection(MONGODBNAME, "organizations");
        $coll->update(
            array('_id' => new MongoId($o->org_id)),
            array('$pull' => array('people' => array('person_id' => $p->person_id)))
        );
    }
}