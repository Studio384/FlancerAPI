<?php

namespace model\interfaces\repositories;

interface IJobRepository {

    public function findAll();
    public function find( $id );
    public function create( $job );
}