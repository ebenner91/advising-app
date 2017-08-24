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
include_once "/home/advisingapp/db-dev.php";

//Check if post is sent from ajax call.
if(isset($_POST['type'])) {
  $type = $_POST['type'];
  
  // createCourse, updateCourse, deleteCourse, addPrereqs, addQuarters, getCoursePrereqs
  if(isset($_POST['id']) || isset($_POST['number']) || isset($_POST['title']) || isset($_POST['credit'])
    || isset($_POST['prereq']) || isset($_POST['quarter']) || isset($_POST['description'])) {
    $id = $_POST['id'];
    $number = $_POST['number'];
    $title = $_POST['title'];
    $credit = $_POST['credit'];
    $prereqs = $_POST['prereq'];
    $quarters = $_POST['quarter'];
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
    case 'getCoursePrereqs' :
      $id = getCourseID($number);
      getPrereqsForCourse($id);
      break;
    case 'getPrereqs' :
      getPrereqOptions();
      break;
    case 'createCourse' :
      createCourse($id, $number, $title, $credit, $prereqs, $quarters, $description);
      break;
    case 'updateCourse' :
      updateCourse($number, $title, $credit, $prereqs, $quarters, $description);
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
 *@param String $id the id of the course; a lowercase, non-spaced version of the course number (Ex: it102)
 *@param String $number the course number (Ex: IT 102)
 *@param String $title the course title (Ex: Programming Fundamentals)
 *@param String $credit the number of credits to be earned from the course
 *(Or in the case of BAS Gen Ed, the total number of credits needed)
 *@param String $prereqs The list of prereqs for the course
 *@param String $quarters The list of quarters the course is offered
 *@param String $description a description of the course
 */
function createCourse($id, $number, $title, $credit, $prereqs, $quarters, $description) {
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
  
  if($quarters != '') {
    addQuarters($id, $quarters);
  }
  if($prereqs != '') {
    addPrereqs($id, $prereqs);
  }
  
  echo json_encode(array('status' => 'success'));
}

/**
 *Function to update information on a course
 *
 *@param String $number the course number
 *@param String $title the title of the course
 *@param String $credit the number of credits to be earned from the course
 *@param String $prereqs the prerequisites for the course
 *@param String $quarters the quarters the course is being offered
 *@param String $description a description of the course
 */
function updateCourse($number, $title, $credit, $prereqs, $quarters, $description) {
  $sql = 'UPDATE course 
          SET title=:title, credit=:credit, description=:description 
          WHERE number=:number';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':title', $title, PDO::PARAM_STR);
  $stmt->bindParam(':credit', $credit, PDO::PARAM_STR);
  $stmt->bindParam(':description', $description, PDO::PARAM_STR);
  $stmt->bindParam(':number', $number, PDO::PARAM_STR);
  $stmt->execute();
  
  if($prereqs != '') {
    updatePrereqs($number, $prereqs);
  }
  if($quarters != '') {
    updateQuarters($number, $quarters);
  }
  
  echo json_encode(array('status' => 'success'));
}

/**
 *Function to delete a course from the database
 *
 *@param String $number the course number
 */
function deleteCourse($number) {
  
  //Delete prereqs and quarters first
  deletePrereqs($number);
  deleteQuarters($number);
  
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
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $courseInfo['title'] = $result['title'];
  $courseInfo['credit'] = $result['credit'];
  $courseInfo['description'] = $result['description'];
  
  $prereqs = getPrereqsForCourse($result['id'], true);
  
  $courseInfo['prereqs'] = $prereqs;
  
  $quarters = getQuartersForCourse($result['id'], true);
  
  $courseInfo['quarters'] = $quarters;
  
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
 *@param String $prereqs a list of ids for the course prereqs
 */
function addPrereqs($course, $prereqs) {
  //Create insert statement, use ON DUPLICATE KEY to prevent duplicates
  $sql = 'INSERT INTO prereqs(course_id, prereq_id) 
          VALUES (:course_id, :prereq_id)
          ON DUPLICATE KEY UPDATE course_id=course_id';
  
  $prereqs = explode(",", $prereqs);
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  foreach($prereqs as $prereq) {
    $stmt->bindParam(':course_id', $course, PDO::PARAM_STR);
    $stmt->bindParam(':prereq_id', $prereq, PDO::PARAM_STR);
    $stmt->execute();
  }
}

/**
 *Function to associate quarters offered with a course
 *
 *@param String $id the id for the course
 *@param String $quarters a list of quarters the course is being offered
 */
function addQuarters($id, $quarters) {
  //Create Insert statement, use ON DUPLICATE KEY to prevent duplicates
  $sql = 'INSERT INTO quarters(course_id, quarter) 
          VALUES (:course_id, :quarter)
          ON DUPLICATE KEY UPDATE course_id=course_id';
          
  $quarters = explode(",", $quarters);
          
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  foreach($quarters as $quarter) {
    $stmt->bindParam(':course_id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':quarter', $quarter, PDO::PARAM_STR);
    $stmt->execute();
  }
}

/**
 *Function to retrieve all prereqs for a given course
 *
 *@param String $courseId the id of the given course
 *@param Boolean $return Default to false. If true, return the result, if false, echo the result.
 *@return Array If $return is set to true, returns an array of the results pulled from the databse
 */
function getPrereqsForCourse($courseId, $return=false) {
  $sql = 'SELECT prereq_id FROM prereqs WHERE course_id = :course_id';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':course_id', $courseId, PDO::PARAM_STR);
  $stmt->execute();
  
  $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
  
  foreach($result as &$prereq) {
    $prereq = getCourseNumber($prereq);
  }
  
  if($return) {
    return $result;
  } else if(!$return) {
    echo json_encode($result);
  }
}

/**
 *Function to retrieve all quarters offered for a given course
 *
 *@param String $courseId the id of the given course
 *@param Boolean $return Default to false. If true, return the result, if false, echo the result.
 *@return Array If $return is set to true, returns an array of the results pulled from the databse
 */
function getQuartersForCourse($courseId, $return=false) {
  $sql = 'SELECT quarter FROM quarters WHERE course_id = :course_id';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':course_id', $courseId, PDO::PARAM_STR);
  $stmt->execute();
  
  $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
  
  if($return) {
    return $result;
  } else if(!$return) {
    echo json_encode($result);
  }
}

/**
 *Function to update prereqs for a given course by adding new ones and deleting removed ones
 *
 *@param String $number the course number for the course
 *@param String $newPrereqs the updated list of prereqs
 */
function updatePrereqs($number, $newPrereqs) {
  
  //Save id to variable
  $courseId = getCourseID($number);
  
  deletePrereqs($number);
  
  addPrereqs($courseId, $newPrereqs);
}

/**
 *Function to update quarters offered for a given course by adding new ones and deleting removed ones
 *
 *@param String $number the course number for the course
 *@param String $newQuarters the updated list of quarters offered
 */
function updateQuarters($number, $newQuarters) {

  //Get id and save to variable
  $courseId = getCourseID($number);
  
  deleteQuarters($number);
  
  addQuarters($courseId, $newQuarters);
}

/**
 *Function to delete all prereqs associated with a course
 *
 *@param String $number the course number for the course
 */
function deletePrereqs($number) {
  
  $courseId = getCourseID($number);
  
  $sql = 'DELETE FROM prereqs WHERE course_id = :course_id';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  
  $stmt->bindParam(':course_id', $courseId, PDO::PARAM_STR);
  $stmt->execute();
  
}

/**
 *Function to delete all quarters associated with a course
 *
 *@param String $number the course number for the course
 */
function deleteQuarters($number) {
  
  $courseId = getCourseID($number);
  
  $sql = 'DELETE FROM quarters WHERE course_id = :course_id';
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  
  $stmt->bindParam(':course_id', $courseId, PDO::PARAM_STR);
  $stmt->execute();
  
}

/**
 *Function to retrieve id for a course based on its course number
 *
 *@param String $number the course number for the given course
 *@return String the id for the course
 */
function getCourseID($number) {
  //Get id for the course
  $sql = "SELECT id FROM course WHERE number = :number";
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':number', $number, PDO::PARAM_STR);
  $stmt->execute();
  
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result['id'];
}

/**
 *Function to retrieve a course number based on the course ID
 *
 *@param String $id the id for the course
 *@return String the course number
 */
function getCourseNumber($id) {
  $sql = "SELECT number FROM course WHERE id = :id";
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':id', $id, PDO::PARAM_STR);
  $stmt->execute();
  
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
  return $result['number'];
}