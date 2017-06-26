<?php

require "CourseModel.php";
require "../db/dbcon.php";


	$db = writeDatabase();

	//Retrieve data from database
    $courseModel = new CourseModel($db);
	
	//$userID = $_GET['uid'];
	$courseNumber = $_GET['coursenum'];
	$column = $_GET['column'];
	$completed = 'n';
	//$program = 'Software Development';

	
	$count = $courseModel->insertCourse(1, $courseNumber, $column, $completed);
	
	echo "Rows Added: " . count;
	
	$db = null;
?>