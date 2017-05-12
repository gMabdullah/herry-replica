<?php 
class crud
{

 private $db;
 public $body = 'Now here';
	 function __construct($db_con)
	 {
	  $this->db = $db_con;
	 }

	 // Select all data from specific table
	public function getAll($p_id, $tbl){
		try {
			
		  $stmt = $this->db->prepare("SELECT * FROM ".$tbl." WHERE id=:id");

		  $stmt->execute(array(":id"=>$p_id));
		  $editRow=$stmt->fetch(PDO::FETCH_OBJ);
		  return $editRow;
		  
	  } catch (PDOException $e) {
			echo $e->getMessage();
		}
	 }
 
}
 ?>