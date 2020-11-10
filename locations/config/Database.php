<?php
	class Database {
		// DB Params
		private $host = 'sql5.acmecorp.com';
		private $db_name = 'root';
		private $username = 'root';
		private $password = 'afjkldKfaGd131f3211#12f';
		private $conn;
		
		//DB Connect
		public function connect() {
			$this->conn = null;
			
			try {
				//$this->conn = new PDO('dblib:host = ' . $this->host . ';dbname=' . $this->db_name,$this->username,$this->password);
				$this->conn = new PDO('sqlsrv:Server=' . $this->host . ';Database=' . $this->db_name,$this->username,$this->password);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			} catch(PDOException $e) {
				echo 'Connection Error: ' . $e->getMessage();
			}
			
			return $this->conn;
				
		}
		
	}