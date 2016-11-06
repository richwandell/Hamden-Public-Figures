<?php

namespace csc545\lib;

use csc545\dbo\MySQLOrganizationDatabase;
use csc545\dbo\MySQLPeopleDatabase;
use csc545\dbo\MongoPeopleDatabase;
use csc545\dbo\MongoOrganizationDatabase;

class DBFactory
{
    const MODE_MYSQL = "MYSQL";
    const MODE_MONGO = "MONGO";

    /**
     * @param string $mode
     * @return MongoPeopleDatabase|MySQLPeopleDatabase
     */
    public static function getPeopleDatabase($mode = self::MODE_MYSQL)
    {
        if(MODE == self::MODE_MYSQL && $mode == self::MODE_MYSQL){
            return new MySQLPeopleDatabase();
        }else{
            return new MongoPeopleDatabase();
        }
    }

    /**
     * @param string $mode
     * @return MongoOrganizationDatabase|MySQLOrganizationDatabase
     */
    public static function getOrganizationDatabase($mode = self::MODE_MYSQL)
    {
        if(MODE == self::MODE_MYSQL && $mode == self::MODE_MYSQL){
            return new MySQLOrganizationDatabase();
        }else{
            return new MongoOrganizationDatabase();
        }
    }
}