<?php

namespace model\repositories;

use model\Company;
use model\dao\CompanyDAO;
use model\interfaces\dao\ICompanyDAO;
use model\interfaces\repositories\ICompanyRepository;
use config\DependencyInjector;

class CompanyRepository implements ICompanyRepository{

    public function __construct( ICompanyDAO $companyDAO = null ) {
        if ( !isset( $companyDAO ) )
            $companyDAO = DependancyInjector::getContainer()['companyDAO'];

        $this->companyDAO = $companyDAO;
    }

    public function findAll() {
        $companys = $this->companyDAO->findAll();

        return $companys;
    }

    public function find( $id ) {
        $company = null;

        if ( $this->isValidId( $id ) )
            $company = $this->companyDAO->find( $id );
                
        return $company;
    }

    public function create( $company ) {
        $createdCompany = null;

        if ( isset( $company ) )
            $createdCompany = $this->companyDAO->create( $company );
            
        return $createdCompany;
    }
    
    private function isValidId( $id ) {
        if ( is_string( $id ) && ctype_digit( trim( $id ) ) )
            $id = (int) $id;

        return is_integer( $id ) && $id >= 0;
    }
}