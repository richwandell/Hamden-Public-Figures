<?php

namespace csc545\dbo;

use DateTime;
use MongoDB\Client as MongoClient;
use MongoDate;
use MongoId;

class MongoPeopleDatabase extends MongoClient implements PeopleInterface
{

    public function __construct()
    {
        parent::__construct(MONGOSERVER);
    }


    /**
     * @param Person $p
     * @return mixed
     */
    public function updatePersonInfo(Person $p)
    {
        $coll = $this->selectCollection(MONGODBNAME, "organizations");
        $coll->updateMany(
            array(
                "people.person_id" => $p->person_id
            ),
            array(
                '$set' => array(
                    'people.$.first_name' => $p->first_name,
                    'people.$.last_name' => $p->last_name,
                    'people.$.full_name' => $p->full_name
                )
            ),
            array(
                "upsert" => false,
                "multi" => true
            )
        );
        if(count($p->organizations) > 0){
            $p->start_date = new MongoDate($p->organizations[0]->person_start_date->getTimestamp());
            $p->end_date = new MongoDate($p->organizations[0]->person_end_date->getTimestamp());
            $p->job_title = $p->organizations[0]->organization_job_title_id;
            $org_id = new MongoId($p->organizations[0]->org_id);
            unset($p->organizations);
            $coll->updateMany(
                array(
                    '_id' => $org_id
                ),
                array(
                    '$addToSet' => array(
                        'people' => $p
                    )
                )
            );
        }
    }

    /**
     * @param Person $p
     * @return mixed
     */
    public function getPersonInfoById(Person $p)
    {
        $coll = $this->selectCollection(MONGODBNAME, "organizations");
        $curs = $coll->find(
            array(
                "people" => array(
                    '$elemMatch' => array("person_id" => (int)$p->person_id)
                )
            ),
            array(
                "address" => 1,
                "notes" => 1,
                "website" => 1,
                "organization_name" => 1,
                "people" => array(
                    '$elemMatch' => array("person_id" => (int)$p->person_id)
                )
            )
        );
        $person = new Person();
        foreach($curs as $org){
            if(!isset($person->person_id)){
                $person->person_id = $org["people"][0]["person_id"];
                $person->first_name = $org["people"][0]["first_name"];
                $person->last_name = $org["people"][0]["last_name"];
                $person->full_name = $org["people"][0]["full_name"];
                $person->organizations = array();
            }
            $organization = new Organization();
            $organization->org_id = $org["_id"];
            $organization->address = $org["address"];
            $organization->notes = $org["notes"];
            $organization->website = $org["website"];
            $organization->organization_name = $org["organization_name"];
            $organization->organization_job_title = $org["people"][0]["job_title"];
            $organization->organization_job_title_id = $org["people"][0]["job_title"];
            $organization->person_start_date = new DateTime('@' . $org["people"][0]["start_date"]->sec);
            $organization->person_end_date = new DateTime('@' . $org["people"][0]["end_date"]->sec);
            $person->organizations[] = $organization;
        }
        return $person;
    }
}