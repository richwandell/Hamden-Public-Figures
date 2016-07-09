<?php

namespace csc545\lib;

use csc545\dbo\MySQLOrganizationDatabase;
use csc545\dbo\MySQLPeopleDatabase;
use csc545\dbo\MongoPeopleDatabase;
use csc545\dbo\MongoOrganizationDatabase;

class DBFactory{

    /**
     * @return MongoPeopleDatabase|MySQLPeopleDatabase
     */
    public static function getPeopleDatabase(){
        if(MODE == "MYSQL"){
            return new MySQLPeopleDatabase();
        }else{
            return new MongoPeopleDatabase();
        }
    }

    /**
     * @return MongoOrganizationDatabase|MySQLOrganizationDatabase
     */
    public static function getOrganizationDatabase(){
        if(MODE == "MYSQL"){
            return new MySQLOrganizationDatabase();
        }else{
            return new MongoOrganizationDatabase();
        }
    }
}