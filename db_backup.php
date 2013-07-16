<?php

 /*
  * ----------------------------------------------------------------------------
  * Nahoosh@cyberscrypt.com wrote this file. As long as you retain this notice you
  * can do whatever you want with this stuff. 
  * ---------------------------------------------------------------------------- 
*/

include('dbconn.php');

$select_tables = "Show tables";

$export = mysql_query ( $select_tables ) 
       or die ( "Sql error : " . mysql_error( ) );
$fields = mysql_num_fields ( $export );

$tables = array();
while( $row = mysql_fetch_row( $export ) )
{
  $tables[] = $row[0];
}

//For all tables
foreach($tables as $table)
{
	echo $table;
	echo "<br/>";
	//create query to select as data from your table
	$select = "SELECT * FROM ".$table;

	//run mysql query and then count number of fields
	$export = mysql_query ( $select ) 
		   or die ( "Sql error : " . mysql_error( ) );
	$fields = mysql_num_fields ( $export );

	//create csv header row, to contain table headers 
	//with database field names
	$header = '';
	for ( $i = 0; $i < $fields; $i++ ) {
		$header .= mysql_field_name( $export , $i ) . ",";
	}

	$header .= "\n";

	//this is where most of the work is done. 
	//Loop through the query results, and create 
	//a row for each

	$data = '';
	while( $row = mysql_fetch_row( $export ) ) {
		$line = '';
		//for each field in the row
		foreach( $row as $value ) {
			//if null, create blank field
			if ( ( !isset( $value ) ) || ( $value == "" ) ){
				$value = ",";
			}
			//else, assign field value to our data
			else {
				$value = str_replace( '"' , '""' , $value );
				$value = '"' . $value . '"' . ",";
			}
			//add this field value to our row
			$line .= $value;
		}
		//trim whitespace from each row
		$data .= trim( $line ) . "\n";
		
	}
	//remove all carriage returns from the data
	$data = str_replace( "\r" , "" , $data );

	$fp = fopen('backups/'.$table.'_backup.txt', 'w');
	fputs($fp,$header);
	fputs($fp,$data);
	fclose($fp);
}

//print "$header\n$data";
exit;
?>
