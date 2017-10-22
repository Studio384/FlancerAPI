<?php

namespace model\interfaces\dao;

interface IFreelancerDAO {

    public function findAll();
    public function find( $id );
    public function create( $freelancer );
}