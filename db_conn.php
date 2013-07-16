<?php
/*
  * ----------------------------------------------------------------------------
  * Normal connection to database. Available from internet!! 
  * ---------------------------------------------------------------------------- 
*/
  	
$con = mysql_connect("server_name","username","password");
if (!$con)
  {
  die('Could not connect to mysql server: ' . mysql_error());
  }
else
{}
  
mysql_select_db("database_name", $con);
 
	if(mysql_select_db("database_name", $con))
	{
		//echo "db selected </br>";
	}
	else
	{
		//echo "db not selected </br>";
	}
	
	

?> 
