<?php
require "CourseModel.php";
require "../db/dbcon.php";


	$db = writeDatabase();

	//Retrieve data from database
    $courseModel = new CourseModel($db);
	
	$currentColumn = $_GET['column'];
	$courseId = $_GET['id'];

	
	$count = $courseModel->rescheduleCourse($currentColumn, $courseId);
	
	echo "Column: " . $currentColumn;
	echo "Course: " . $courseId;
	echo "Rows Changed: " . $count;
	
	$db = null;

?>