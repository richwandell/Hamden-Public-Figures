<?php
use csc545\lib\DBFactory;
use PHPUnit\Framework\TestCase;

class DBFactoryTest extends TestCase
{
    /**
     * @var \csc545\dbo\MySQLOrganizationDatabase
     */
    public $mysql_org;
    /**
     * @var \csc545\dbo\MySQLPeopleDatabase
     */
    public $mysql_peo;
    /**
     * @var \csc545\dbo\MongoOrganizationDatabase
     */
    public $mongo_org;
    /**
     * @var \csc545\dbo\MongoPeopleDatabase
     */
    public $mongo_peo;

    public function setUp()
    {
        $this->mysql_org = DBFactory::getOrganizationDatabase();
        $this->mysql_peo = DBFactory::getPeopleDatabase();
        $this->mongo_org = DBFactory::getOrganizationDatabase(DBFactory::MODE_MONGO);
        $this->mongo_peo = DBFactory::getPeopleDatabase(DBFactory::MODE_MONGO);
    }

    public function testReturnsCorrect()
    {
        $this->assertInstanceOf('csc545\dbo\MySQLOrganizationDatabase', $this->mysql_org);
        $this->assertInstanceOf('csc545\dbo\MySQLPeopleDatabase', $this->mysql_peo);
        $this->assertInstanceOf('csc545\dbo\MongoOrganizationDatabase', $this->mongo_org);
        $this->assertInstanceOf('csc545\dbo\MongoPeopleDatabase', $this->mongo_peo);
    }

    /**
     * @depends testReturnsCorrect
     */
    public function testJobTitles()
    {
        $it = $this->mysql_org->getJobTitles();
        $this->assertInstanceOf('csc545\lib\MySQLObjectIterator', $it);
        foreach($it as $obj){
            $this->assertInstanceOf('csc545\dbo\JobTitle', $obj);
        }

        $it = $this->mongo_org->getJobTitles();
        $this->assertInstanceOf('csc545\lib\MongoObjectIterator', $it);
        foreach($it as $obj){
            $this->assertInstanceOf('csc545\dbo\JobTitle', $obj);
        }
    }

    public function testNamesAndIds()
    {
        $it = $this->mysql_org->getAllNamesAndIds();
        $this->assertInstanceOf('csc545\lib\MySQLObjectIterator', $it);

        foreach($it as $obj){
            $this->assertInstanceOf('csc545\dbo\Organization', $obj);
        }

        $it = $this->mongo_org->getAllNamesAndIds();
        $this->assertInstanceOf('csc545\lib\MongoObjectIterator', $it);

        foreach($it as $obj){
            $this->assertInstanceOf('csc545\dbo\Organization', $obj);
        }
    }

}