<?php
require("defination.inl.php");

class connection
	{
		//public function __construct()
		 var $servername = DB_HOST;
		 var	$username = DB_USER;
		 var	$password = DB_PASS;
		 var	$dbname = DB_NAME;	
		public function get_conn()
		{
			/*Connection Code*/
			
				
			
			try {
			
			
					$conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					echo 'Ok Connection Created';
					return $conn;
			
				}
			catch(PDOException $e)
				{
					echo "Error: " . $e->getMessage();
				}
				//$conn = null;
				//return false;			
		}
		public function getData($query,$conn)
		{ 
			try
			{
				//$conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
					// set the PDO error mode to exception
				//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
				$stmt=$conn->query($query);
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			catch(PDOException $e)
			{
				echo "Error=".$e->getMessage();
			}
			
		}
			
	}

	
	

 

	

		echo "Nai";
$obj=new connection();
$conn=$obj->get_conn();

foreach($obj->getData("select userid from security",$conn) as $row)
{
	echo $row['userid'];	
}

echo "success";


date_default_timezone_set("Asia/Kolkata");
echo date('d-m-y h:i:s');
	
?>