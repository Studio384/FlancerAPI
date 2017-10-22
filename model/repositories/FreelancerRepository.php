<?php

namespace model\repositories;

use model\Freelancer;
use model\dao\FreelancerDAO;
use model\interfaces\dao\IFreelancerDAO;
use model\interfaces\repositories\IFreelancerRepository;
use config\DependencyInjector;

class FreelancerRepository implements IFreelancerRepository {
    
    public function __construct( IFreelancerDAO $freelancerDAO = null ) {
        if ( !isset( $freelancerDAO ) )
            $freelancerDAO = DependancyInjector::getContainer()['freelancerDAO'];

        $this->freelancerDAO = $freelancerDAO;
    }

    public function findAll() {
        $freelancers = $this->freelancerDAO->findAll();

        return $freelancers;
    }

    public function find( $id ) {
        $freelancer = null;

        if ( $this->isValidId( $id ) )
            $freelancer = $this->freelancerDAO->find( $id );

        return $freelancer;
    }

    public function create( $freelancer ) {
        $createdFreelancer = null;

        if ( isset( $freelancer ) )
            $createdFreelancer = $this->freelancerDAO->create( $freelancer );

        return $createdFreelancer;
    }
    
    private function isValidId( $id ) {
        if ( is_string( $id ) && ctype_digit( trim( $id ) ) )
            $id = (int) $id;

        return is_integer( $id ) && $id >= 0;
    }
}