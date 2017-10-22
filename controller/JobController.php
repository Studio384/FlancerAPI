<?php

namespace controller;

use model\interfaces\repositories\IJobRepository;
use config\DependencyInjector;

class JobController {

    public function __construct( IJobRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['jobRepository'];

        $this->repository = $repository;
    }

    public function handleFindAll() {
        $statuscode = 200;
        $jobs = array();
        try {
            $jobs = $this->repository->findAll();
        } catch (Exception $e) {
            $statuscode=500;
        }

        $this->returnJSON( $jobs, $statuscode );
    }

    public function handleFind( $id ) {
        $statuscode = 200;
        $job = null;
        try {
            $job = $this->repository->find( $id );
            if ( $job == null ) {
                 $statuscode = 204;
            }
        } catch (Exception $e) {
            $statuscode = 500;
        }
        $this->returnJSON( $job, $statuscode );
    }

    public function handleCreate( $job ) {
        $createdJob = null;
        $statuscode = 201;
        
        if ( isset( $job )) {
            try {
                $createdJob = $this->repository->create( $job );
                if ( !isset( $createdJob )) {
                    $statuscode = 500;
                }
            } catch (Exception $e) {
                $statuscode = 500;
            }   
        }
        else {
            $statuscode = 400;
        }
        $this->returnJSON( $createdJob, $statuscode );
    }

    private function returnJSON( $object, $statuscode ) {
        header( 'Content-Type: application/json; charset=utf-8' );
        http_response_code( $statuscode );
        echo json_encode( $object );
    }
}