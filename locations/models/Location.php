<?php
	class Location {
		// DB stuff
		private $conn;
		private $table = 'Location';
		
		// Location Properties
		public $Location_id;
		public $LocationName;
		public $LocationCountry;
		public $LocationContinent;
		public $IsActive;
		public $CountryCode;
		
		// Constructor with DB
		public function __construct($db) {
			$this->conn = $db;
		}
		
		// Get Locations
		public function read() {
			//Create query
			$query = 'SELECT
						t.Location_Id,
						t.LocationName,
						t.LocationCountry,
						t.LocationContinent,
						t.IsActive,
						t.CountryCode			 
					FROM ' . $this->table . ' t';

			// Prepare statement
			$stmt = $this->conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			// Execute query
			$stmt->execute();
			//$stmt->nextRowset();
			//$stmt->closeCursor();
			
			// For Testing Use
			//$rows = $stmt->fetchAll();
			//var_dump($rows);
			//$count = count($rows);
			//echo $count;
			//$stmt->debugDumpParams();

			return $stmt;

		}

		// Get Single Location
		public function read_single() {
			//Create query
			$query = 'SELECT Top 1 
						t.Location_Id,
						t.LocationName,
						t.LocationCountry,
						t.LocationContinent,
						t.IsActive,
						t.CountryCode			 
					FROM ' . $this->table . ' t
					WHERE t.Location_Id = ?';

			// Prepare statement
			$stmt = $this->conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

			// Bind ID
			$stmt->bindParam(1, $this->locid);
			// Execute query
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// Set Properties
			$this->Location_Id = $row['Location_Id'];
			$this->LocationName = $row['LocationName'];
			$this->LocationCountry = $row['LocationCountry'];
			$this->LocationContinent = $row['LocationContinent'];
			$this->IsActive = $row['IsActive'];
			$this->CountryCode = $row['CountryCode'];

		}

		// Create Location
		public function create() {
			// Create query
			$query = 'INSERT INTO ' . $this->table . '
				(LocationName,LocationCountry,LocationContinent,IsActive,CountryCode) 
				VALUES (:LocationName,:LocationCountry,:LocationContinent,:IsActive,:CountryCode)';

			// Prepare statement
			$stmt = $this->conn->prepare($query);

			// Clean data
			$this->LocationName = htmlspecialchars(strip_tags($this->LocationName));
			$this->LocationCountry = htmlspecialchars(strip_tags($this->LocationCountry));
			$this->LocationContinent = htmlspecialchars(strip_tags($this->LocationContinent));
			$this->IsActive = htmlspecialchars(strip_tags($this->IsActive));
			$this->CountryCode = htmlspecialchars(strip_tags($this->CountryCode));

			// Bind data
			$stmt->bindParam(':LocationName',$this->LocationName);
			$stmt->bindParam(':LocationCountry',$this->LocationCountry);
			$stmt->bindParam(':LocationContinent',$this->LocationContinent);
			$stmt->bindParam(':IsActive',$this->IsActive);
			$stmt->bindParam(':CountryCode',$this->CountryCode);
			
			// Execute query
			if($stmt->execute()) {
				return true;
			}

			// Print error if something goes wrong
			printf("Error %s. \n", $stmt->error);

			return false;

		}

		// Update Location
		public function update() {
			// Update query
			$query = 'UPDATE ' . $this->table . ' SET LocationName = :LocationName, LocationCountry = :LocationCountry, LocationContinent = :LocationContinent, IsActive = :IsActive, CountryCode = :CountryCode WHERE Location_Id = :Location_Id';

			// Prepare statement
			$stmt = $this->conn->prepare($query);

			// Clean data
			$this->LocationName = htmlspecialchars(strip_tags($this->LocationName));
			$this->LocationCountry = htmlspecialchars(strip_tags($this->LocationCountry));
			$this->LocationContinent = htmlspecialchars(strip_tags($this->LocationContinent));
			$this->IsActive = htmlspecialchars(strip_tags($this->IsActive));
			$this->CountryCode = htmlspecialchars(strip_tags($this->CountryCode));
			$this->Location_Id = htmlspecialchars(strip_tags($this->Location_Id));

			// Bind data
			$stmt->bindParam(':LocationName',$this->LocationName);
			$stmt->bindParam(':LocationCountry',$this->LocationCountry);
			$stmt->bindParam(':LocationContinent',$this->LocationContinent);
			$stmt->bindParam(':IsActive',$this->IsActive);
			$stmt->bindParam(':CountryCode',$this->CountryCode);
			$stmt->bindParam(':Location_Id',$this->Location_Id);
			
			// Execute query
			if($stmt->execute()) {
				return true;
			}

			// Print error if something goes wrong
			printf("Error %s. \n", $stmt->error);

			return false;

		}

		// Delete Location
		public function delete() {
			// Delete query
			$query = 'DELETE FROM ' . $this->table . '
			WHERE Location_Id in (:Location_Id)';

			// Prepare statement
			$stmt = $this->conn->prepare($query);

			// Clean data
			$this->Location_Id = htmlspecialchars(strip_tags($this->Location_Id));	
			
			$implodeLocId = implode(',' , explode(',',$this->Location_Id));

			// Bind data
			$stmt->bindParam(':Location_Id',$implodeLocId);
			
			// Bind data
			//$stmt->bindParam(':Location_Id',$this->Location_Id);

			// Execute query
			if($stmt->execute()) {
				return true;
			}

			// Print error if something goes wrong
			printf("Error %s. \n", $stmt->error);

			return false;
			
		}
	}