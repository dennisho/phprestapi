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

	// Location query
  $result = $location->read();
	// Get row count
  $num = $result->rowCount();

  // Check if any locations
  if($num > 0) {
		// Location Array
		$locatoins_arr = array();
		$locations_arr['data'] = array();
	
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			extract($row);
	
			$location_item = array(
				'Location_Id' => $Location_Id,
				'LocationName' => $LocationName,
				'LocationCountry' => $LocationCountry,
				'LocationContinent' => $LocationContinent,
				'IsActive' => $IsActive,
				'CountryCode' => $CountryCode
			); 
	
			// Push to "data"
			array_push($locations_arr['data'], $location_item);
		}

    //Turn to JSON & output
    echo json_encode($locations_arr);
  } else {
    // No Locations
    echo json_encode(
      array('message' => 'No Locations Found')
    );
  }

   
