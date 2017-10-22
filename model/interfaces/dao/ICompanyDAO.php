<?php

namespace model\interfaces\dao;

interface ICompanyDAO {

    public function findAll();
    public function find( $id );
    public function create( $company );
}