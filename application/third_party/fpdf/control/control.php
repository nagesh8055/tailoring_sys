		<?php
		 
		require("defination.inl.php");
		/*function get_client_ip() {
			$ipaddress = '';
			if ($_SERVER['HTTP_CLIENT_IP'])
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			else if($_SERVER['HTTP_X_FORWARDED_FOR'])
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else if($_SERVER['HTTP_X_FORWARDED'])
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			else if($_SERVER['HTTP_FORWARDED_FOR'])
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			else if($_SERVER['HTTP_FORWARDED'])
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
			else if($_SERVER['REMOTE_ADDR'])
				$ipaddress = $_SERVER['REMOTE_ADDR'];
			else
				$ipaddress = 'UNKNOWN';
			return $ipaddress;
		} 
		*/

		class connection
			{
				 var $servername = DB_HOST;
				 var	$username = DB_USER;
				 var	$password = DB_PASS;
				 var	$dbname = DB_NAME;	
				public function get_conn()
				{
					try {
							$conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
							$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
							return $conn;
						}
					catch(PDOException $e)
						{
							echo "Error: " . $e->getMessage();
						}
							
				}
				public function getData($query,$conn)
				{ 
					try
					{ 
						$stmt=$conn->query($query);
						return $stmt->fetchAll(PDO::FETCH_ASSOC);
					}
					catch(PDOException $e)
					{
						 
					}
				}
				
				//Method For Calling Procedure
				/**
					Function Name : callProcedure Author : Nagesh Haridas 11/03/2016 6:20PM
					@params
					$procedure_name - Name OF Procedure
					$values - Array Of Values
					$conn connection Object

					@Returns String
					Successfull
					Failed
					**
					*/
				public function callProcedure($procedure_name,$values,$conn)
				{
					$str="";
					for($i=0;$i<count($values);$i++)
						{
						  $str=$str.':p'.$i;
							if(!($i==(count($values)-1)))
								{
									$str=$str.',';
								}
						}
					$str="call $procedure_name(".$str.")";
				
				//Calling Procedure
					try {
							$stmt=$conn->prepare($str);
							for($i=0;$i<count($values);$i++)
								{
									$stmt->bindParam('p'.$i,$values[$i],PDO::PARAM_STR);
								}
							$stmt->execute();
							return "Successfull";
						}
					catch(Exception $e)
						{
							echo $e->getMessage();
							return "Failed";
						}
				
			    }
		}
		
		class Utilities
		{
			public function getCurrentDate()
			{
				date_default_timezone_set("Asia/Kolkata");
				return '20'.date('y-m-d');
			}
			function getUserAgent()
			{
				return $agent=$_SERVER['HTTP_USER_AGENT'];
			}
			function getClientIp() 
			{ 
				$ipaddress = '';
				if (getenv('HTTP_CLIENT_IP'))
					$ipaddress = getenv('HTTP_CLIENT_IP');
				else if(getenv('HTTP_X_FORWARDED_FOR'))
					$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
				else if(getenv('HTTP_X_FORWARDED'))
					$ipaddress = getenv('HTTP_X_FORWARDED');
				else if(getenv('HTTP_FORWARDED_FOR'))
					$ipaddress = getenv('HTTP_FORWARDED_FOR');
				else if(getenv('HTTP_FORWARDED'))
				   $ipaddress = getenv('HTTP_FORWARDED');
				else if(getenv('REMOTE_ADDR'))
					$ipaddress = getenv('REMOTE_ADDR');
				else
					$ipaddress = 'UNKNOWN';
				return $ipaddress;
			}
			function getClientMacAddress()
			{
				return 'cdc-8cd-#rf';
			}
			function getTotalNosFromString($str)
			{
				return substr_count($str,',')+1;
			}
			function getMessageCount($str,$flg)//Method Returns message count using message Lenght
			{
				if($flg==1)//for unicode message count
				{
					return ceil(strlen($str)/160)*4;
				}
				else
				{
					return ceil(strlen($str)/160);
				}
			}
			
			function getNumbersArray($str)
			{
				$tmp=array();
				$temp_str=$str;
				while(strlen($temp_str) > 0)
				{
					array_push($tmp,substr($temp_str,0,10));
					$temp_str=substr($temp_str,11,strlen($temp_str));
				}
				return $tmp;
			}
			function getUniqueNumbersUrlString($tmp_array)
			{
				$str='';
				//$tmp_array=array_unique($arr);
				
				echo 'Array Size :'.sizeof($tmp_array);
				for($i=0 ; $i<sizeof($tmp_array) ; $i++ )
				{
						
						$str=$str.$tmp_array[$i];	
						if($i!=(sizeof($tmp_array)-1))
						{
							$str=$str.',';
						}
						//echo '<br>i='.$i;
					
				}
				return $str;
			}
			
		}
	
		class login extends connection
			{
				 public function login_user($uid,$upass,$date,$ip,$agent,$conn)
				{
					$stmt=$conn->prepare("call pro6_check_userid(:uid,:upass,:date,:ip,:agent)");
					$stmt->bindParam(':uid',$uid);
					$stmt->bindParam(':upass',$upass);
					$stmt->bindParam(':date',$date);
					$stmt->bindParam(':ip',$ip);	
					$stmt->bindParam(':agent',$agent);		
					$stmt->execute();
					
					 $res = $conn->query('select fun4_get_result() as res');
					 $res->setFetchMode(PDO::FETCH_ASSOC);
					//return $q;
					 //$res=fun4_get_result()
					 foreach($res as $row)
						{
							return $row['res'];		
						}
					  return 'Executed file';	 
				}
			}
	class New_Login  extends connection
	{
		public function chkAuthontication($userid,$password,$pin,$ip,$mac,$p_flg,$conn)
		{
		   try
		   {
			   date_default_timezone_set("Asia/Kolkata");
	           $datec=date('y-m-d h:i:s');
				
			//pro7_check_custuserid_web(in p_userid varchar(12),in p_pass text,in p_pin varchar(5),in p_ip varchar(30),in p_mak varchar(30),in p_flg tinyint)

/*
	IN
		1st p_userid is used for get the userid
		2nd p_pass is used for get the password
		3rd p_pin is used for get the pin
		4th p_ip is used for get the ip address of client machine
		5th p_mak is used for get the mak address of client machine
		6th p_flg is set the 
			0=userid  login
			1=mobile  login	*/
				
				
		    //$stmt=$conn->prepare("call pro2_check_userid(:userid,:password,:date,:ip,:agent)");
			$stmt=$conn->prepare("call pro7_check_custuserid_web(:userid,:password,:pin,:ip,:mac,:p_flg)");
			$stmt->bindParam(':userid',$userid);
			$stmt->bindParam(':password',$password);
			$stmt->bindParam(':pin',$pin);
			$stmt->bindParam(':ip',$ip);
			$stmt->bindParam(':mac',$mac);
			$stmt->bindParam(':p_flg',$p_flg);
		    $stmt->execute();
			
			 $result = $conn->query('select @res as res');
			 $result->setFetchMode(PDO::FETCH_ASSOC);
			 foreach($result as $row)
				 {
					return $row['res'];		
				 }
			  return 'Executed file';	 
		    }
		  catch(Exception $e)
		  {
		     echo $e->getMessage();
			 
		  }
		  
		   
		}
	}	
	
	//pro9_add_group(in p_group_name varchar(20),in p_userid varchar(12),in p_noc int unsigned)
/*
	IN
		1st p_group_name is used for get group Name
		2nd p_userid is used for get the userid
		3rd p_noc is used for get the noumber of contact no are avilable
	OUT
		@custid
			return the customer id
		@groupid
			return the group id
*/


	/*class Group extends connection
	{
		public function addGroup($group_name,$userid,$noc,$conn)
		{
		   try
		   {
			   date_default_timezone_set("Asia/Kolkata");
	           $datec=date('y-m-d h:i:s');
				
			
				
		    
			$stmt=$conn->prepare("call pro9_add_group(:group_name,:userid,:noc)");
			$stmt->bindParam(':group_name',$group_name);
			$stmt->bindParam(':userid',$userid);
			$stmt->bindParam(':noc',$noc);
			$stmt->execute();
			
			 $result = $conn->query('select @res as res');
			 $result->setFetchMode(PDO::FETCH_ASSOC);
			 foreach($result as $row)
				 {
					return $row['res'];		
				 }
			  return 'Executed file';	 
		    }
		  catch(Exception $e)
		  {
		     echo $e->getMessage();
			 
		  }
		  
		   
		}
	}*/	
			
			
	?>