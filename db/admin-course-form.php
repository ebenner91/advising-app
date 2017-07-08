<?php
/**
 * Green River IT Advising App
 * @author Arnold Koh <arnold@kohded.com>
 * @version 2.0, developed 9/23/16
 * @url http://advisingapp.greenrivertech.net/
 * admin-course-form.php
 * Database queries for admin course form.
 */

//Commenting out original include statement and replacing with one that works on the dev subdomain
//include '../../db.php';
include "/home/advisingapp/db-dev.php";

//Check if post is sent from ajax call.
if(isset($_POST['type'])) {
  $type = $_POST['type'];
  
  // addCourse, updateCourse, deleteCourse
  if(isset($_POST['id']) || isset($_POST['number']) || isset($_POST['title']) || isset($_POST['credit'])
    || isset($_POST['prereq']) || isset($_POST['description'])
  ) {
    $id = $_POST['id'];
    $number = $_POST['number'];
    $title = $_POST['title'];
    $credit = $_POST['credit'];
    $prereq = $_POST['prereq'];
    $description = $_POST['description'];
  }
  
  // autocompleteCourse
  if(isset($_POST['courseInput'])) {
    $courseInput = '%' . $_POST['courseInput'] . '%';
  }
  
  // getCourseInfo
  if(isset($_POST['courseNumber'])) {
    $courseNumber = $_POST['courseNumber'];
  }
  
  switch($type) {
    case 'addCourse' :
      addCourse($id, $number, $title, $credit, $prereq, $description);
      break;
    case 'updateCourse' :
      updateCourse($number, $title, $credit, $prereq, $description);
      break;
    case 'deleteCourse' :
      deleteCourse($number);
      break;
    case 'autocompleteCourse' :
      autocompleteCourse($courseInput);
      break;
    case 'getCourseInfo' :
      getCourseInfo($courseNumber);
      break;
    default:
      break;
  }
}

/**
 *Function to add a course to the database
 *
 *@param String $id the id of the course; a lowercase, non-spaced version of the title (Ex: it102)
 *@param String $number the course number (Ex: IT 102)
 *@param String $title the course title (Ex: Programming Fundamentals)
 *@param String $credit the number of credits to be earned from the ccourse
 *(Or in the case of BAS Gen Ed, the total number of credits needed)
 *@param String $prereq prereqs needed before taking the course (May need to alter parameter for new prereq storage)
 *@param String $description a description of the course
 */
function addCourse($id, $number, $title, $credit, $prereq, $description) {
  $sql = 'INSERT INTO course(id, number, title, credit, prereq, description) 
          VALUES (:id, :number, :title, :credit, :prereq, :description)';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':id', $id, PDO::PARAM_STR);
  $stmt->bindParam(':number', $number, PDO::PARAM_STR);
  $stmt->bindParam(':title', $title, PDO::PARAM_STR);
  $stmt->bindParam(':credit', $credit, PDO::PARAM_STR);
  $stmt->bindParam(':prereq', $prereq, PDO::PARAM_STR);
  $stmt->bindParam(':description', $description, PDO::PARAM_STR);
  $stmt->execute();
  
  echo json_encode(array('status' => 'success'));
}

/**
 *Function to update information on a course
 *
 *@param String $number the course number
 *@param String $title the title of the course
 *@param String $credit the number of credits to be earned from the course
 *@param String $prereq prereqs needed before taking the course (May need to alter this for the new prereq storage)
 *@param String $description a description of the course
 */
function updateCourse($number, $title, $credit, $prereq, $description) {
  $sql = 'UPDATE course 
          SET number=:number, title=:title, credit=:credit, prereq=:prereq, description=:description 
          WHERE number=:number';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':number', $number, PDO::PARAM_STR);
  $stmt->bindParam(':title', $title, PDO::PARAM_STR);
  $stmt->bindParam(':credit', $credit, PDO::PARAM_STR);
  $stmt->bindParam(':prereq', $prereq, PDO::PARAM_STR);
  $stmt->bindParam(':description', $description, PDO::PARAM_STR);
  $stmt->execute();
  
  echo json_encode(array('status' => 'success'));
}

/**
 *Function to delete a course from the database
 *
 *@param String $number the course number
 */
function deleteCourse($number) {
  $sql = 'DELETE FROM course WHERE number=:number';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':number', $number, PDO::PARAM_STR);
  $stmt->execute();
  
  echo json_encode(array('status' => 'success'));
}

/**
 *Function to retrieve course info for autocomplete functions
 *Takes input and returns all courses that could match the given input
 *
 *@param String $courseInput input from the course number input field
 */
function autocompleteCourse($courseInput) {
  $courses = array();
  $sql = 'SELECT * FROM course WHERE number LIKE (:courseInput)';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':courseInput', $courseInput, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetchAll();
  
  foreach($result as $row) {
    $course = array();
    $course['value'] = $row['number'];
    $course['data'] = '';
    $courses[] = $course;
  }
  
  echo json_encode($courses);
}

/**
 *Function to retrieve info for a course
 *
 *@param $courseNumber the course number for the course the user is looking up
 */
function getCourseInfo($courseNumber) {
  $courseInfo = array();
  $sql = 'SELECT * FROM course c WHERE c.number = :courseNumber';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':courseNumber', $courseNumber, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetchAll();
  
  foreach($result as $row) {
    $courseInfo['title'] = $row['title'];
    $courseInfo['credit'] = $row['credit'];
    $courseInfo['prereq'] = $row['prereq'];
    $courseInfo['description'] = $row['description'];
  }
  
  echo json_encode($courseInfo);
}

/**
 *Function to retrieve list of possible prereqs
 */
function getPrereqOptions() {
  $courseList = array();
  $sql = 'SELECT id, number FROM course ORDER BY number';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  echo json_encode($result);
}

?>