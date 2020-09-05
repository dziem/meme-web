<?php
	class Database{
		private $servername = "localhost";
		private $username = "root";
		private $password = "";
		private $database = "meme";
		public $conn;

		function getConnection(){
			$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
			if ($this->conn->connect_error) {
				die("Connection failed: " . $this->conn->connect_error);
			}
			return $this->conn;
		}
		
		function closeConnection(){
			mysqli_close($this->conn);
		}
		
		function selectAll($str){
			$this->getConnection();
			$dbRes = $this->conn->query($str);
			$result = array();
			while ($row = $dbRes->fetch_object()){
				$result[] = $row;
			}
			$this->closeConnection();
			return $result;
		}
		
		function query($str){
			$this->getConnection();
			$this->conn->query($str);
			$this->closeConnection();
		}
	}
?>