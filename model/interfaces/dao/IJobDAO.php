<?php

namespace model\interfaces\dao;

interface IJobDAO {

    public function findAll();
    public function find( $id );
    public function create( $job );
}