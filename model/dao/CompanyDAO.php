<?php

namespace model\dao;

use \PDO;
use PDOException;
use model\factories\CompanyFactory;
use model\interfaces\dao\ICompanyDAO;
use config\DependencyInjector;

class CompanyDAO implements ICompanyDAO {

    public function __construct( PDO $connection = null ) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM companies' );
            $statement->execute();
            $rows = $statement->fetchAll( PDO::FETCH_ASSOC );
            
            $companies = array();

            for ( $i = 0; $i < count( $rows ); $i++ ) {
                $companies[$i] = CompanyFactory::CreateFromArray( $rows[$i] );
            } 

            return $companies;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function find( $id ) {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM companies WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $company = $statement->fetchAll();

            if ( count( $company ) > 0 ) {
                return CompanyFactory::CreateFromArray( $company[0] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function create( $company ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO companies (name, street, number, city, zip, country) VALUES (:name, :street, :number, :city, :zip, :country)' );
            $name = $company->getName();
            $statement->bindParam( ':name', $name, PDO::PARAM_INT );
            $street = $company->getStreet();
            $statement->bindParam( ':street', $street, PDO::PARAM_INT );
            $number = $company->getNumber();
            $statement->bindParam( ':number', $number, PDO::PARAM_INT );
            $city = $company->getCity();
            $statement->bindParam( ':city', $city, PDO::PARAM_INT );
            $zip = $company->getZip();
            $statement->bindParam( ':zip', $zip, PDO::PARAM_INT );
            $country = $company->getCountry();
            $statement->bindParam( ':country', $country, PDO::PARAM_INT );
            
            $success = $statement->execute();

            if ( $success ) {
                $id = $this->connection->lastInsertId();
                $company->setId( $id );

                return $company;
            }
            

            echo 'stap 4';
            return null;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }
}