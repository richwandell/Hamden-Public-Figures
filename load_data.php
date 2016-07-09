<?php
/**
 * @file This is a command line script used for populating MongoDB from MySQL
 * In Mongo our data is stored in the organizations collection
 */
use csc545\dbo\JobTitle;
use csc545\dbo\MongoOrganizationDatabase;
use csc545\dbo\MySQLOrganizationDatabase;
use csc545\dbo\Organization;
use csc545\dbo\Person;

include_once "bootstrap.php";

$out = shell_exec('mysql -u ' . MYSQLUSER . ' -p'. MYSQLPASS .' < mysql_database.sql');

$database = new MySQLOrganizationDatabase();
$people_to_create = 1000000;
$stm = $database->prepare("insert into person (last_name, first_name, full_name) values (?, ?, ?)");
$stm1 = $database->prepare("insert into person_organization 
(organization_id, person_id, start_date, end_date, job_title_id) values (?, ?, ?, ?, ?)");
echo "Starting MySQL million records" . PHP_EOL;
$start = microtime(true);
for($x = 0; $x < $people_to_create; $x++){
    $stm->execute(array(
        (string)$x,
        (string)$x,
        (string)$x
    ));
    $insert = $database->lastInsertId();
    $now = new DateTime();
    $stm1->execute(array(
        $x % 65,
        $insert,
        $now->getTimestamp(),
        $now->getTimestamp(),
        $x % 28
    ));
}
$end = microtime(true);
echo "Finished loading million records " . ($end - $start);

echo "Starting Mongo load" .PHP_EOL;

echo "Starting Mongo Indexing" . PHP_EOL;
$start = microtime(true);
$mongo = new MongoOrganizationDatabase();
$coll = $mongo->selectCollection(MONGODBNAME, "organizations");
$coll->createIndex(array("people.person_id" => 1));
$end = microtime(true);
echo "Ended Mongo Indexing" . ($end - $start) . PHP_EOL;

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
order by
    o.organization_id asc;
";

$stm = $database->prepare($query);
$stm->execute();
$mongo = new MongoOrganizationDatabase();
$coll = $mongo->selectCollection(MONGODBNAME, "organizations");
$coll->drop();

$corgid = 0;
$org = false;
$max_person_id = 0;
while($result = $stm->fetch(PDO::FETCH_ASSOC)){
    if((int)$result["org_id"] != $corgid) {
        if($org != false) {
            $coll->insert($org);
        }
        $org = new Organization();
        $org->organization_name = preg_replace('/\n|\r/', "", $result["organization_name"]);
        $org->type = preg_replace('/\n|\r/', "", $result["organization_type"]);
        $org->website = preg_replace('/\n|\r/', "", $result["website"]);
        $org->year_modified = preg_replace('/\n|\r/', "", $result["year_modified"]);
        $org->address = preg_replace('/\n|\r/', "", $result["address"]);
        $org->notes = preg_replace('/\n|\r/', "", $result["notes"]);
        unset($org->org_id);
        unset($org->person_count);
        unset($org->organization_job_title);
        unset($org->organization_job_title_id);
        unset($org->person_start_date);
        unset($org->person_end_date);
    }
    if(!empty($result["person_id"])){
        $person = new Person();
        $person->first_name = preg_replace('/\n|\r/', "", $result["first_name"]);
        $person->last_name = preg_replace('/\n|\r/', "", $result["last_name"]);
        $person->full_name = preg_replace('/\n|\r/', "", $result["full_name"]);
        $person->person_id = (int)$result["person_id"];
        $person->start_date = new MongoDate(strtotime($result["start_date"]));
        $person->end_date = new MongoDate(strtotime($result["end_date"]));
        $person->job_title = preg_replace('/\n|\r/', '', $result["job_title"]);
        unset($person->organizations);
        $org->people[] = $person;
        if($max_person_id < $result["person_id"]){
            $max_person_id = $result["person_id"];
        }
    }
    $corgid = $result["org_id"];
}
$coll->insert($org);


$coll->createIndex(array("people.person_id" => 1));

$query = "select job_title from job_title";
$stm = $database->prepare($query);

$stm->execute();
$coll = $mongo->selectCollection(MONGODBNAME, "job_titles");
$coll->drop();
while($result = $stm->fetch(PDO::FETCH_ASSOC)){
    $jt = new JobTitle();
    $jt->job_title_text = preg_replace('/\n|\r/', '', $result["job_title"]);

    $coll->insert($jt);
}

$coll = $mongo->selectCollection(MONGODBNAME, "counts");
$coll->drop();

$coll->insert(array(
    'person_id' => (int)$max_person_id
));



