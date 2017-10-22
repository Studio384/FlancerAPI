<?php

header( 'Content-Type: application/json; charset=utf-8' );
require_once('vendor/autoload.php');

use model\factories\CompanyFactory;
use controller\CompanyController;
use model\factories\FreelancerFactory;
use controller\FreelancerController;
use model\factories\JobFactory;
use controller\JobController;

error_reporting(E_ALL);

// Dirty hack to allow Yannick to work without Vagrant
if ( file_exists( 'C:\dontvagrant.txt' ) ) {
	$root = "flancerapi/";
} else {
	$root = "";
}

$router = new AltoRouter();
$router->setBasePath('/');

try {
	# curl -X GET http://192.168.1.250/company/
	$router->map('GET', $root.'company/', 
		function() {
			$controller = new CompanyController();
			$controller->handleFindAll();
		}
	);
	
	# curl -X GET http://192.168.1.250/freelancer/
	$router->map('GET', $root.'freelancer/', 
		function() {
			$controller = new FreelancerController();
			$controller->handleFindAll();
		}
	);

	# curl -X GET http://192.168.1.250/job/
	$router->map('GET', $root.'job/', 
		function() {
			$controller = new JobController();
			$controller->handleFindAll();
		}
	);

	# curl -X GET http://192.168.1.250/company/1
	$router->map('GET', $root.'company/[i:getal]', 
		function( $id ) {
			$controller = new CompanyController();
			$controller->handleFind( $id );
		}
	);
	
	# curl -X GET http://192.168.1.250/freelancer/1
	$router->map('GET', $root.'freelancer/[i:getal]', 
		function( $id ) {
			$controller = new FreelancerController();
			$controller->handleFind( $id );
		}
	);
	
	# curl -X GET http://192.168.1.250/job/1
	$router->map('GET', $root.'job/[i:getal]', 
		function( $id ) {
			$controller = new JobController();
			$controller->handleFind( $id );
		}
	);

	$router->map('POST', $root.'company/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			$company = CompanyFactory::CreateFromArray( $data );
			$controller = new CompanyController();
			$controller->handleCreate( $company );
		}
	);

	$router->map('POST', $root.'freelancer/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			$freelancer = FreelancerFactory::CreateFromArray( $data );
			$controller = new FreelancerController();
			$controller->handleCreate( $freelancer );
		}
	);
	
	$router->map('POST', $root.'job/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			$job = JobFactory::CreateFromArray( $data );
			$controller = new JobController();
			$controller->handleCreate( $job );
		}
	);

	$match = $router->match();

	if( $match && is_callable( $match['target'] ) ){
		call_user_func_array( $match['target'], $match['params'] ); 
	} else {
		echo 'Geen match';
	}

} catch (Exception $e) {
	var_dump($e);
} finally {
	$pdo = null;
}
