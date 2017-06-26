<?php
    //Start a new session with the server
    session_start();

    //If the authentication session variable does not exist, create it
    if(!isset($_SESSION['auth'])){
        $_SESSION['auth'] = false;
    }

	
	//if the user isn't authorized to make new events, kick them back to the home page
   if($_SESSION['auth'] != true){
    echo '<script>window.location = "login.php";</script>';
   }
   //logout
	echo "<a role='button' class='authentication-link btn btn-info' href='dependancies/php/logout.php'>LOGOUT</a>";
   
	//back to scheduling tool
	echo "<a role='button' class='authentication-link btn btn-info' href='admin.php'>SCHEDULER</a>";
		
	include "dependancies/php/header.php";
	
	/*
	*	@author Stephen King
	*	@created 6/9/2016
	*	@version 1.0
	*
	*	This document allows admins to add, update and remove courses from the course database.
	*	It should also retroactively remove all instances of the class from custom schedules.
	*/
	
	?>

<br>
<br>
<div class="col-md-12 container add-course-panel">
    <div class='panel panel-default box-shadow--2dp'>
        <div class='panel-heading'>
            <p class="title-text">Add/Edit/Delete Courses</p>
        </div>

<?php

require_once "dependancies/db/dbcon.php";
require_once "dependancies/models/CourseModel.php";

//Create a database connection
$dbRead = readDatabase();
$dbWrite = writeDatabase();
//Create a new VerifyModel object with the database connection
$courseModel = new CourseModel($dbRead);
	 
$courseID = ""; 
$courseCode = "";
$courseNumber = "";
$courseTitle = ""; 	 
$courseDescription = "";
$courseCredits = "";
$coursePrereqs = "";

$editing = false;    
        
//If this is ever set to false, halt progress        
$isComplete = true;    
  
 //Initiate Editing 
	if(isset($_POST['edit-btn'])){


		//Show commit edit button	
		$editing = true;
		
		//DB Stuff
		$dbRead = readDatabase();
		$courseModel = new CourseModel($dbRead);
		$course = $courseModel->getCourse($_POST['editcourse'])->fetch();
	
		 $courseID = $_POST['editcourse'];	 
		 $courseNumber = $course['coursenum'];
		 $courseTitle = $course['title']; 	 
		 $courseDescription = $course['description'];
		 $courseCredits = $course['credits'];
		 $coursePrereqs = $course['prereqs'];  
	
		//Set variables for editing
		//setEditVariables($_POST['editcourse']);
		$dbRead = null;
		
	
	//Create a new course
	}else if(isset($_POST['create-btn'])){
    
		//store info for sticky form
		$courseDescription = $_POST['coursedescription'];
		$courseTitle = $_POST['coursetitle'];
		$courseCredits = $_POST['coursecredits'];
		$coursePrereqs = $_POST['courseprereqs'];
		$courseNumber = $_POST['coursenumber'];
		$courseID = $_POST['courseid'];
		
		//Backend verification pool    
		isEmpty($courseDescription);
		isEmpty($courseTitle);
		isEmpty($courseCredits);
		isEmpty($coursePrereqs);
		isEmpty($courseNumber);
		isEmpty($courseID);
  
  
		if($isComplete){

				addCourse($courseID, $courseNumber, $courseTitle, $courseDescription, $courseCredits, $coursePrereqs);
				
				echo '<script>window.location = "coursetool.php";</script>';
			} else {
				echo "Please fill out required forms";
			}
			
	//Update an existing course
    }else if(isset($_POST['update-btn'])){
		
		//store info for sticky form
		$courseDescription = $_POST['coursedescription'];
		$courseTitle = $_POST['coursetitle'];
		$courseCredits = $_POST['coursecredits'];
		$coursePrereqs = $_POST['courseprereqs'];
		$courseNumber = $_POST['coursenumber'];
		$courseID = $_POST['courseid'];
		
		//Backend verification pool    
		isEmpty($courseDescription);
		isEmpty($courseTitle);
		isEmpty($courseCredits);
		isEmpty($coursePrereqs);
		isEmpty($courseNumber);
		isEmpty($courseID);
		
		//If everything checks out, update the course
		if($isComplete){
			updateCourse($courseID, $courseNumber, $courseTitle, $courseDescription, $courseCredits, $coursePrereqs);
			echo 'Course Updated!';
		} else {
			echo "Please fill out required forms";
		}
		
		$editing = false;
	}else if(isset($_POST['delete-btn'])){
		deleteCourse($_POST['courseid']);
	}

	
	/********************************************
	*	Make certain required fields have content
	********************************************/
	function isEmpty($testString){

		if(!isset($testString) || empty($testString) || is_null($testString)){
		return $isComplete = false;
		}
	}
	
	/********************************************
	*	Update an existing course
	********************************************/
	function updateCourse($courseID, $courseNumber, $courseTitle, $courseDescription, $courseCredits, $coursePrereqs){
		
		//DB Stuff
		$dbWrite = writeDatabase();
		$courseModel = new CourseModel($dbWrite);
		$course = $courseModel->editCourse($courseID, $courseNumber, $courseTitle, $courseDescription, $courseCredits, $coursePrereqs);
		
		//close connection
		$dbWrite = null;
	}
	
	/********************************************
	*	Add a new course
	********************************************/
	function addCourse($courseID, $courseNumber, $courseTitle, $courseDescription, $courseCredits, $coursePrereqs){
		
		//DB stuff
		$dbWrite = writeDatabase();
		$courseModel = new CourseModel($dbWrite);
		$course = $courseModel->addCourse($courseID, $courseNumber, $courseTitle, $courseDescription, $courseCredits, $coursePrereqs);
		
		//close connection
		$dbWrite = null;
	}
	
	/********************************************
	*	Delete Selected Course
	********************************************/
	function deleteCourse($courseID){
		
		//DB stuff
		$dbWrite = writeDatabase();
		$courseModel = new CourseModel($dbWrite);
		$course = $courseModel->removeCourse($courseID);
		
		//close connection
		$dbWrite = null;
	}
?>

<div class="panel-body">
    <!-- Login Form -->
        <div class="login">

            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                
				<!--Existing Courses-->
                <label class="event-label" for="editcourse">Select Course To Edit Or Leave Blank For New</label>
				
				<!--Drop down list to edit or delete classes-->
                    <select class="form-control event-form event-type-dropdown" name="editcourse" required>
					<option value="none"> Select a Class to Edit</option>
					<?php
					
						$courseList = $courseModel->getAllCourses();
						
						foreach($courseList as $row){
							echo "<option value={$row['courseid']}>{$row['coursenum']}</option>";
                        
						}
						
						$dbRead = null;
						?>
                    </select>
					<br>
					<input type='submit' class='btn btn-info' id='edit-btn' name='edit-btn' value='EDIT'>
					<input type='submit' class='btn btn-danger pull-right' name='delete-btn' value='DELETE'>
			</form>
					
                <br>
				<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
				<!--Course ID-->
				<p>Course ID (itxxx) (required)</p>
                <input type="text" maxlength="10" class="form-control" id="courseid" name="courseid" value="<?php echo $courseID; ?>" placeholder="itxxx" required>
                <br>
				
				<!--Course Number-->
				<p>Course Number (IT xxx) (required)</p>
                <input type="text" maxlength="10" class="form-control" id="coursenumber" name="coursenumber" value="<?php echo $courseNumber; ?>" placeholder="IT xxx" required>
                <br>

				<!--Course Credits-->
				<p>Course Credits (required)</p>
				<input type="number" maxlength="2" class="form-control" id="coursecredits" name="coursecredits" value="<?php echo $courseCredits; ?>" placeholder="0" required>
				<br>
				
				 <!--Course Title-->
				 <p>Course Title(required)</p>
                <input type="text" maxlength="50" class="form-control" id="coursetitle" name="coursetitle" value="<?php echo $courseTitle; ?>" placeholder="Course Title (Required)" required>
                <br>
				
				<!--Course Prereqs-->
				<p>Course Prereqs (required)</p>
                <input type="text" maxlength="50" class="form-control" id="courseprereqs" name="courseprereqs" value="<?php echo $coursePrereqs; ?>" placeholder="Course Prereqs (Required)" required>
                <br>
				
                <!--Course Description-->
				<p>Course Description (required)</p>
                <textarea rows="10" cols="250" class="form-control restrict-textarea" id="coursedescription" name="coursedescription" placeholder="Course Description (required)" required><?php echo $courseDescription; ?></textarea>
                
                <br>
                <!--Submit Button-->
				<?php 
				
					if($editing === false){
							echo '<input type="submit" class="btn btn-info" id="create-btn" name="create-btn" value="Create">';
					}else{
							echo '<input type="submit" class="btn btn-info" id="update-btn" name="update-btn" value="Update">';
						}
						?>
                    </form>
                </div>
            </div>
        </div>
    </div>

