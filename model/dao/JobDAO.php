<?php

namespace model\dao;

use \PDO;
use PDOException;
use model\factories\JobFactory;
use model\interfaces\dao\IJobDAO;
use config\DependencyInjector;

class JobDAO implements IJobDAO {

    public function __construct( PDO $connection = null) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM jobs' );
            $statement->execute();
            $rows = $statement->fetchAll( PDO::FETCH_ASSOC );

            $jobs = array();

            for ( $i = 0; $i < count( $rows ); $i++ ) {
                $jobs[$i] = JobFactory::CreateFromArray( $rows[$i] );
            }

            return $jobs;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function find( $id ) {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM jobs WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $row = $statement->fetchAll();

            if ( count( $row ) > 0 ) {
                return JobFactory::CreateFromArray( $row[0] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function create( $job ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO jobs (title, company_id, minimum_bid, description, street, number, city, zip, country) VALUES (:title, :company_id, :minimum_bid, :description, :street, :number, :city, :zip, :country)' );
            $title = $job->getTitle();
            $statement->bindParam( ':title', $title, PDO::PARAM_INT );
            $companyId = $job->getCompanyId();
            $statement->bindParam( ':company_id', $companyId, PDO::PARAM_STR );
            $minimumBid =  $job->getMinimumBid();
            $statement->bindParam( ':minimum_bid', $minimumBid, PDO::PARAM_INT);
            $description = $job->getDescription();
            $statement->bindParam( ':description', $description, PDO::PARAM_INT );
            $street = $job->getStreet();
            $statement->bindParam( ':street', $street, PDO::PARAM_INT );
            $number = $job->getNumber();
            $statement->bindParam( ':number', $number, PDO::PARAM_INT );
            $city = $job->getCity();
            $statement->bindParam( ':city', $city, PDO::PARAM_INT );
            $zip = $job->getZip();
            $statement->bindParam( ':zip', $zip, PDO::PARAM_INT );
            $country = $job->getCountry();
            $statement->bindParam( ':country', $country, PDO::PARAM_INT );
            $success = $statement->execute();

            if ( $success ) {
                $id = $this->connection->lastInsertId();
                $job->setId( $id );

                return $job;
            }
            
            return null;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }
}