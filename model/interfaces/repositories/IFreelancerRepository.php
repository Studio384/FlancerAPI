<?php

namespace model\interfaces\repositories;

interface IFreelancerRepository {

    public function findAll();
    public function find( $id );
    public function create( $freelancer );
}