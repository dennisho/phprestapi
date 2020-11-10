<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// Headers
	header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

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

  // Get Loation ID
  $location->locid = isset($_GET['locid']) ? $_GET['locid'] : die();	

  // Get Location
  $location->read_single();

  // Create array
  $location_arr = array(
    'Location_Id' => $location->Location_Id,
    'LocationName' => $location->LocationName,
    'LocationCountry' => $location->LocationCountry,
    'LocationContinent' => $location->LocationContinent,
    'IsActive' => $location->IsActive,
    'CountryCode' => $location->CountryCode
  ); 

  // Make JSON
  print_r(json_encode($location_arr));