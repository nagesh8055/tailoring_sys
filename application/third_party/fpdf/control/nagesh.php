<?php

include('control.php');


/**
Function Name : callProcedure Author : Nagesh Haridas 11/03/2016 6:20PM
@params
$procedure_name - Name OF Procedure
$values - Array Of Values
$conn connection Object
**
*/
 function callProcedure($procedure_name,$values,$conn)
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
		echo '<strong>'.$str.'<br/>';
		//Calling Procedure
		try {
				$stmt=$conn->prepare($str);
				for($i=0;$i<count($values);$i++)
					{
						$stmt->bindParam('p'.$i,$values[$i],PDO::PARAM_STR);
					}
				$stmt->execute();
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		
	}
		
$obj=new connection ();
		try
		{
				//callProcedure("pro2_profession",array("60","1","Java Developer","Uma","10000.00","60000.00","Company","Director","Nothing"),$obj->get_conn());
				//callProcedure("pro2_profession",array("60","1","Java Developer","Uma","10000.00","60000.00","Company","Director","0"),$obj->get_conn());
				 date_default_timezone_set("Asia/Kolkata");
				$datec=date('Y-m-d'); 
				$values=array("0","Ganesh Haridas","Nandkumar","father","haridas ves","8055299494","9130076160","mail","1989-11-01","1","1","1","Shidlya","2000.00","0","5 FT ","o+","0","10");
				 callProcedure("pro1_registration",$values,$obj->get_conn());
				 //callProcedure("pro1_test",array("Harshi","1991-07-28"),$obj->get_conn());
		}
		  catch(Exception $e)
			{
				echo $e->getMessage();
			}
	
?>		