<?php

namespace csc545\dbo;

use Iterator;

interface OrganizationInterface{
    /**
     * @return Iterator
     */
    public function getJobTitles();
    /**
     * @return Iterator
     */
    public function getAllTypes();

    /**
     * @param Organization $o
     * @return Iterator
     */
    public function getPeople(Organization $o);

    /**
     * @param OrganizationType $type_query
     * @return Iterator
     */
    public function getOrganizations(OrganizationType $type_query);

    /**
     * @return Iterator
     */
    public function getAllNamesAndIds();

    /**
     * @param Organization $o
     * @return mixed
     */
    public function getOrganizationRecord(Organization $o);

    /**
     * @param Person $p
     * @param Organization $o
     * @return mixed
     */
    public function removePerson(Person $p, Organization $o);
}