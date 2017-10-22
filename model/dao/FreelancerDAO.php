<?php

namespace model\dao;

use \PDO;
use PDOException;
use model\factories\FreelancerFactory;
use model\interfaces\dao\IFreelancerDAO;
use config\DependencyInjector;

class FreelancerDAO implements IFreelancerDAO {

    public function __construct( PDO $connection = null ) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM freelancers' );
            $statement->execute();
            $rows = $statement->fetchAll( PDO::FETCH_ASSOC );
            
            $freelancers = array();

            for ( $i = 0; $i < count( $rows ); $i++ ) {
                $freelancers[$i] = FreelancerFactory::CreateFromArray( $rows[$i] );
            } 

            return $freelancers;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function find( $id ) {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM freelancers WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $freelancer = $statement->fetchAll();

            if ( count( $freelancer ) > 0 ) {
                return FreelancerFactory::CreateFromArray( $freelancer[0] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function create( $freelancer ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO freelancers (name, street, number, city, zip, country) VALUES (:name, :street, :number, :city, :zip, :country)' );
            $name = $freelancer->getName();
            $statement->bindParam( ':name', $name, PDO::PARAM_INT );
            $street = $freelancer->getStreet();
            $statement->bindParam( ':street', $street, PDO::PARAM_INT );
            $number = $freelancer->getNumber();
            $statement->bindParam( ':number', $number, PDO::PARAM_INT );
            $city = $freelancer->getCity();
            $statement->bindParam( ':city', $city, PDO::PARAM_INT );
            $zip = $freelancer->getZip();
            $statement->bindParam( ':zip', $zip, PDO::PARAM_INT );
            $country = $freelancer->getCountry();
            $statement->bindParam( ':country', $country, PDO::PARAM_INT );
            $success = $statement->execute();

            if ( $success ) {
                $id = $this->connection->lastInsertId();
                $freelancer->setId( $id );

                return $freelancer;
            }
            
            return null;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }
}