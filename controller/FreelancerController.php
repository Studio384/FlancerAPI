<?php

namespace controller;

use model\interfaces\repositories\IFreelancerRepository;
use config\DependencyInjector;

class FreelancerController {

    public function __construct( IFreelancerRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['freelancerRepository'];

        $this->repository = $repository;
    }

    public function handleFindAll() {
        $statuscode = 200;
        $companies = array();

        try {
            $companies = $this->repository->findAll();
        } catch ( Exception $e ) {
            $statuscode=500;
        }

        $this->returnJSON( $companies, $statuscode );
    }

    public function handleFind( $id ) {
        $statuscode = 200;
        $freelancer = null;

        try {
            $freelancer = $this->repository->find( $id );
            if ( $freelancer == null ) {
                 $statuscode = 204;
            }
        } catch ( Exception $e ) {
            $statuscode = 500;
        }

        $this->returnJSON( $freelancer, $statuscode );
    }

    public function handleCreate( $freelancer ) {
        $createdFreelancer = null;
        $statuscode = 201;

        if ( isset( $freelancer ) ) {
            try {
                $createdFreelancer = $this->repository->create( $freelancer );
                if ( !isset( $createdFreelancer ) ) {
                    $statuscode = 500;
                }
            } catch ( Exception $e ) {
                $statuscode = 500;
            }   
        } else {
            $statuscode = 400;
        }
        
        $this->returnJSON( $createdFreelancer, $statuscode );
    }

    private function returnJSON( $object, $statuscode ) {
        header( 'Content-Type: application/json' );
        http_response_code( $statuscode );
        echo json_encode( $object );
    }
}