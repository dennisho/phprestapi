<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// Headers
	header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Acccess-Control-Allow-Methods: PUT');
  header('Acccess-Control-Allow-Headers: Acccess-Control-Allow-Headers,Content-Type,Acccess-Control-Allow-Methods,Authorization,X-Requested-With,Aim');

	include_once dirname(__FILE__).'/../config/Database.php';
  include_once dirname(__FILE__).'/../models/Location.php';
	
	// Get API Key and Value
	$apikeyflag = 'n';
	$headers =  getallheaders();
	foreach($headers as $key=>$val){
		if($key == 'Aim' && $val == 'Ore9MmvVaF2N4Luew33rhrbhaE70uE') {
			$apikeyflag = 'y';
		}
	}
	
	// Invalid API Key end session
	if($apikeyflag == 'n') { die(); }

	// Instantiate DB & connect
	$database = new Database();
	
  $db = $database->connect();
	
  // Instantiate location object
  $location = new Location($db);

  // Get raw posted data
  $data =json_decode(file_get_contents("php://input"));

  // Set ID to update
  $location->Location_Id = $data->Location_Id;

  $location->LocationName = $data->LocationName;
	$location->LocationCountry = $data->LocationCountry;
	$location->LocationContinent = $data->LocationContinent;
	$location->IsActive = $data->IsActive;
  $location->CountryCode = $data->CountryCode;
  
  // Update post
  if($location->update()) {
    echo json_encode(
      array('message' => 'Location Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Location Not Updated')
    );
  }