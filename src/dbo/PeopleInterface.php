<?php
namespace csc545\dbo;

interface PeopleInterface{
    /**
     * @param Person $p
     * @return mixed
     */
    public function updatePersonInfo(Person $p);
    /**
     * @param Person $p
     * @return mixed
     */
    public function getPersonInfoById(Person $p);
}

