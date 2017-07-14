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
    || isset($_POST['description'])
  ) {
    $id = $_POST['id'];
    $number = $_POST['number'];
    $title = $_POST['title'];
    $credit = $_POST['credit'];
    $description = $_POST['description'];
  }
  
  // addPrereqs
  if(isset($_POST['prereqs']) && isset($_POST['id'])) {
    $prereqs = $_POST['prereqs'];
    $id = $_POST['id'];
  }
  // addQuarters
  if(isset($_POST['id']) && isset($_POST['quarter'])) {
    $id = $_POST['id'];
    $quarters = $_POST['quarter'];
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
    case 'addQuarters' :
      addQuarters($id, $quarters);
      break;
    case 'addPrereqs' :
      addPrereqs($id, $prereqs);
      break;
    case 'getPrereqs' :
      getPrereqOptions();
      break;
    case 'addCourse' :
      addCourse($id, $number, $title, $credit, $description);
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
 *@param String $credit the number of credits to be earned from the course
 *(Or in the case of BAS Gen Ed, the total number of credits needed)
 *@param String $description a description of the course
 */
function addCourse($id, $number, $title, $credit, $description) {
  $sql = 'INSERT INTO course(id, number, title, credit, description) 
          VALUES (:id, :number, :title, :credit, :description)';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':id', $id, PDO::PARAM_STR);
  $stmt->bindParam(':number', $number, PDO::PARAM_STR);
  $stmt->bindParam(':title', $title, PDO::PARAM_STR);
  $stmt->bindParam(':credit', $credit, PDO::PARAM_STR);
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
  $sql = 'SELECT id, number FROM course ORDER BY number';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  echo json_encode($result);
}

/**
 *Function to associate prereqs with a course
 *
 *@param String $course the id for the course
 *@param Array $prereqs Array of ids for the course prereqs
 */
function addPrereqs($course, $prereqs) {
  $sql = 'INSERT INTO prereqs(course_id, prereq_id) 
          VALUES (:course_id, :prereq_id)';
  
  $prereqs = explode(",", $prereqs);
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  foreach($prereqs as $prereq) {
    $stmt->bindParam(':course_id', $course, PDO::PARAM_STR);
    $stmt->bindParam(':prereq_id', $prereq, PDO::PARAM_STR);
    $stmt->execute();
  }
  
  echo json_encode(array('status' => 'success'));
}

/**
 *Function to associate quarters offered with a course
 *
 *@param String $id the id for the course
 *@param Array $quarters an array of quarters the course is being offered
 */
function addQuarters($id, $quarters) {
  $sql = 'INSERT INTO quarters(course_id, quarter) 
          VALUES (:course_id, :quarter)';
          
  $quarters = explode(",", $quarters);
          
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  foreach($quarters as $quarter) {
    $stmt->bindParam(':course_id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':quarter', $quarter, PDO::PARAM_STR);
    $stmt->execute();
  }
  
  echo json_encode(array('status' => 'success'));
}

/*
 *Function to retrieve all prereqs for a given course
 *
 *@param String $courseId the id of the given course
 */
function getPrereqsForCourse($courseId) {
  $sql = 'SELECT prereq_id FROM prereqs WHERE course_id = :course_id';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':course_id', $courseId, PDO::PARAM_STR);
  $stmt->execute();
  
  $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
  
  echo json_encode($result);
}

/*
 *Function to retrieve all quarters offered for a given course
 *
 *@param String $courseId the id of the given course
 */
function getQuartersForCourse($courseId) {
  $sql = 'SELECT quarter FROM quarters WHERE course_id = :course_id';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':course_id', $courseId, PDO::PARAM_STR);
  $stmt->execute();
  
  $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
  
  echo json_encode($result);
}

?>