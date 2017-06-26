<?php

/*
* Database Connection File
* Author: Stephen King
* Version 2016.4.14
*
* This makes the physical database connection.
* !!! THIS FILE SHOULD NOT BE IN PUBLIC HTML !!!
*/

function readDatabase(){
    
    //For Live
	//$username = "grtech_advisor";
	//$password = "{rva)Ovd-kEG";
	
	//For Testing
	$username = "advising_write";
	$password = "NuQ,nAn+q]zS";
    
    try {
		//For Testing
        $conn = new PDO("mysql:host=$servername;dbname=advising_app", $username, $password);
		
		//For Live
		//$conn = new PDO("mysql:host=$servername;dbname=grtech_db", $username, $password);
		
		
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn; 
        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
}

function writeDatabase(){
    
    $servername = "localhost";
	
	//For Live
	//$username = "grtech_advisor";
	//$password = "{rva)Ovd-kEG";
	
	//For Testing
	$username = "advising_write";
	$password = "NuQ,nAn+q]zS";
    
    try {
		
		//For Testing
        $conn = new PDO("mysql:host=$servername;dbname=advising_app", $username, $password);
		
		//For Live
		//$conn = new PDO("mysql:host=$servername;dbname=grtech_db", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn; 
        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
}
		
function loginDatabase(){
	$servername = "localhost";
	$username = "tps_test_read";
	$password = "w8.~7DyCX]$8";
    
    try {
			$conn = new PDO("mysql:host=$servername;dbname=tps_test", $username, $password);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn; 
		}catch(PDOException $e){
			echo "Connection failed: " . $e->getMessage();
        }
	}

?>