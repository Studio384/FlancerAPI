<?php

namespace model\interfaces\repositories;

interface ICompanyRepository {

    public function findAll();
    public function find( $id );
    public function create( $company );
}