<?php
require "CourseModel.php";
require "../db/dbcon.php";


	$db = writeDatabase();

	//Retrieve data from database
    $courseModel = new CourseModel($db);
	
	$courseId = $_GET['id'];

	
	$count = $courseModel->removeCourse($courseId);
	
	echo "Course: " . $courseId;
	echo "Rows Changed: " . $count;
	
	$db = null;

?>