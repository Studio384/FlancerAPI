<?php

namespace controller;

use model\interfaces\repositories\ICompanyRepository;
use config\DependencyInjector;

class CompanyController {

    public function __construct( ICompanyRepository $repository = null ) {
        if ( !isset( $repository ) )
            $repository = DependencyInjector::getContainer()['companyRepository'];

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
        $company = null;

        try {
            $company = $this->repository->find( $id );
            if ( $company == null ) {
                 $statuscode = 204;
            }
        } catch ( Exception $e ) {
            $statuscode = 500;
        }

        $this->returnJSON( $company, $statuscode );
    }

    public function handleCreate( $company ) {
        $createdCompany = null;
        $statuscode = 201;

        if ( isset( $company ) ) {
            print_r($company);

            try {
                $createdCompany = $this->repository->create( $company );

                if ( !isset( $createdCompany ) ) {
                    $statuscode = 500;
                }
            } catch ( Exception $e ) {
                $statuscode = 500;
            }   
        } else {
            $statuscode = 400;
        }
        
        $this->returnJSON( $createdCompany, $statuscode );
    }

    private function returnJSON( $object, $statuscode ) {
        header( 'Content-Type: application/json' );
        http_response_code( $statuscode );
        echo json_encode( $object );
    }
}