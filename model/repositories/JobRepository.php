<?php

namespace model\repositories;

use model\Job;
use model\dao\JobDAO;
use model\interfaces\dao\IJobDAO;
use model\interfaces\repositories\IJobRepository;
use config\DependencyInjector;

class JobRepository implements IJobRepository {
    
    public function __construct( IJobDAO $jobDAO = null) {
        if ( !isset( $jobDAO ) )
            $jobDAO = DependancyInjector::getContainer()['jobDAO'];

        $this->jobDAO = $jobDAO;
    }

    public function findAll() {
        $jobs = $this->jobDAO->findAll();

        return $jobs;
    }

    public function find( $id ) {
        $job = null;

        if ( $this->isValidId( $id ) )
            $job = $this->jobDAO->find( $id );

        return $job;
    }

    public function create( $job ) {
        $createdJob = null;

        if ( isset( $job ) )
            $createdJob = $this->jobDAO->create( $job );

        return $createdJob;
    }
    
    private function isValidId( $id ) {
        if ( is_string( $id ) && ctype_digit( trim( $id ) ) )
            $id = (int) $id;

        return is_integer( $id ) && $id >= 0;
    }
}