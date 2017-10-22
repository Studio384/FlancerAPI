<?php

namespace config;

require_once('vendor/autoload.php');

use PDO;
use Pimple\Container;
use model\dao\CompanyDAO;
use model\repositories\CompanyRepository;
use model\dao\FreelancerDAO;
use model\repositories\FreelancerRepository;
use model\dao\JobDAO;
use model\repositories\JobRepository;

abstract class DependencyInjector {
    public static function getContainer() {
        $container = new Container();

        $container['pdo'] = $container->factory( function() {
            ob_start();
            require 'dbconfig.json';           
            $json = ob_get_contents();
            ob_end_clean();
            $db = json_decode( $json, true );
            $dsn = 'mysql:host=' . $db['hostname'] . ';dbname=' . $db['database'];
            
            return new PDO( $dsn, $db['user'], $db['password'] );
        });

        $container['companyDAO'] = $container->factory( function( $c ) {
            return new CompanyDAO( $c['pdo'] );
        });

        $container['companyRepository'] =  $container->factory( function( $c ) {
            return new CompanyRepository( $c['companyDAO'] );
        });

        $container['freelancerDAO'] = $container->factory( function( $c ) {
            return new FreelancerDAO( $c['pdo'] );
        });

        $container['freelancerRepository'] =  $container->factory( function( $c ) {
            return new FreelancerRepository( $c['freelancerDAO'] );
        });
        
        $container['jobDAO'] = $container->factory( function($c) {
            return new JobDAO( $c['pdo'] );
        });

        $container['jobRepository'] =  $container->factory( function($c) {
            return new JobRepository( $c['jobDAO'] );
        });

        return $container;
    }
}