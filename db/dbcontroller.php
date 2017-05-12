<?php
try {
	// include_once('constants.php');
	class DBController {
		// $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
		
		private $server = 'localhost';
		private $username = 'root';
		private $password = 'root';
		private $db = 'signup';
		private $conn = '';

		// private $host 	  = $url["host"];
		// private $user 	  = $url["user"];
		// private $password = $url["pass"];
		// private $database = substr($url["path"], 1);
		// private $conn;
		
		function __construct($conn = '') {
			$this->conn = new PDO("mysql:host=$this->server;dbname=$this->db;", $this->username, $this->password);
		var_dump($conn);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
		// function connectDB() {
		// 	$db_con = new PDO("mysql:host={$server};dbname={$db}",$username, $password);
		// 	$db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// 	// $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		// 	return $db_con;
		// }
		
		function runQuery($query) {

			$result = $conn->query($query);
			$result->execute();
			foreach($result as $row){
				$resultset[] = $row;
			}

			// $result = mysqli_query($this->conn,$query);
			// while($row=mysqli_fetch_assoc($result)) {
			// 	$resultset[] = $row;
			// }		
			if(!empty($resultset))
				return $resultset;
		}
		
		function numRows($query) {
			$result = $conn->query($query);
			$rowcount = $result->rowCount();

			// $result  = mysqli_query($this->conn,$query);
			// $rowcount = mysqli_num_rows($result);
			return $rowcount;	
		}
	}// END class

	} catch (PDOException $e) {
	echo $e->getMessage();
}
?>
