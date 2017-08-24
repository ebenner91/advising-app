<?php
/**
 * Green River IT Advising App
 * @author Arnold Koh <arnold@kohded.com>
 * @version 2.0, developed 9/23/16
 * @url http://advisingapp.greenrivertech.net/
 * admin-degree-map.php
 * Database queries for admin degree map functionality.
 */

//Commenting out original include statement and replacing with one that works on the dev subdomain
//include '../../db.php';
include_once "/home/advisingapp/db.php";
include_once "admin-course-form.php";

//Check if post is sent from ajax call.
if(isset($_POST['type'])) {
  $type = $_POST['type'];
  
  // sortCourseToFrom
  if(isset($_POST['yearIdFrom']) || isset($_POST['quarterFrom']) || isset($_POST['quarterCoursesFrom']) ||
    isset($_POST['yearIdTo']) || isset($_POST['quarterTo']) || isset($_POST['quarterCoursesTo'])
  ) {
    $yearIdFrom = $_POST['yearIdFrom'];
    $quarterFrom = $_POST['quarterFrom'];
    $quarterCoursesFrom = $_POST['quarterCoursesFrom'];
    $yearIdTo = $_POST['yearIdTo'];
    $quarterTo = $_POST['quarterTo'];
    $quarterCoursesTo = $_POST['quarterCoursesTo'];
  }
  
  // addCourse, removeCourse, sortCoursesInQuarter
  if(isset($_POST['courses']) || isset($_POST['yearId']) || isset($_POST['quarter'])) {
    $courses = $_POST['courses'];
    $yearId = $_POST['yearId'];
    $quarter = $_POST['quarter'];
  }
  
  //checkMissingPrereqs
  if(isset($_POST['course']) && isset($_POST['degreeId']) && isset($_POST['quarter']) && isset($_POST['year'])) {
    $course = $_POST['course'];
    $degreeId = $_POST['degreeId'];
    $quarter = $_POST['quarter'];
    $year = $_POST['year'];
  }
  
  switch($type) {
    case 'checkMissingPrereqs' :
      checkMissingPrereqs($degreeId, $course, $year, $quarter);
      break;
    case 'sortCourseInQuarter' :
      sortCourseInQuarter($yearId, $quarter, $courses);
      break;
    case 'sortCourseToFrom' :
      sortCourseToFrom($yearIdFrom, $quarterFrom, $quarterCoursesFrom, $yearIdTo, $quarterTo, $quarterCoursesTo);
      break;
    case 'addCourse' :
      addCourse($courses, $yearId, $quarter);
      break;
    case 'removeCourse' :
      removeCourse($courses, $yearId, $quarter);
      break;
    default:
      break;
  }
}

/**
 *Function to update the course order in the degree map when moving courses from one quarter to another
 *
 *@param String $yearIdFrom the id of the degree year the course is being moved from
 *@param String $quarterFrom the quarter the course is being moved from
 *@param String $quarterCoursesFrom the new list of courses for the quarter the course was moved from
 *@param String $yearIdTo the year the course is being moved to
 *@param String $quarterTo the quarter the course is being moved to
 *@param String $quarterCoursesTo the updated list of courses for the quarter the course was moved to
 */
function sortCourseToFrom($yearIdFrom, $quarterFrom, $quarterCoursesFrom, $yearIdTo, $quarterTo, $quarterCoursesTo)
{
  $sqlFrom = "UPDATE year SET $quarterFrom=:quarterCoursesFrom WHERE id=:yearIdFrom";
  $sqlTo = "UPDATE year SET $quarterTo=:quarterCoursesTo WHERE id=:yearIdTo";
  
  $db = dbConnect();
  $stmtFrom = $db->prepare($sqlFrom);
  $stmtTo = $db->prepare($sqlTo);
  $db = null;
  $stmtFrom->bindParam(':yearIdFrom', $yearIdFrom, PDO::PARAM_STR);
  $stmtFrom->bindParam(':quarterCoursesFrom', $quarterCoursesFrom, PDO::PARAM_STR);
  $stmtTo->bindParam(':yearIdTo', $yearIdTo, PDO::PARAM_STR);
  $stmtTo->bindParam(':quarterCoursesTo', $quarterCoursesTo, PDO::PARAM_STR);
  $updateFrom = $stmtFrom->execute();
  $updateTo = $stmtTo->execute();
  
  if($updateFrom || $updateTo) {
    echo json_encode(array('status' => 'success'));
  }
  else {
    echo json_encode(array('status' => 'failed'));
  }
}

/**
 *Function to update course ordering within a quarter
 *
 *@param String $yearId the id of the degree year the course is being moved within
 *@param String $quarter the quarter the course is being moved within
 *@param String $courses the updated list of courses in the quarter
 */
function sortCourseInQuarter($yearId, $quarter, $courses)
{
  $sql = "UPDATE year SET $quarter=:courses WHERE id=:yearId";
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  
  $db = null;
  $stmt->bindParam(':yearId', $yearId, PDO::PARAM_STR);
  $stmt->bindParam(':courses', $courses, PDO::PARAM_STR);
  $update = $stmt->execute();
  
  if($update) {
    echo json_encode(array('status' => 'success'));
  } else {
    echo json_encode(array('status' => 'failed'));
  }
}

/**
 *Function to add a course to the degree map
 *
 *@param String $courses the updated list of courses for the given quarter
 *@param String $yearId the id for the degree year being edited
 *@param String $quarter the quarter being edited
 */
function addCourse($courses, $yearId, $quarter)
{
  $sql = "UPDATE year SET $quarter=:courses WHERE id=:yearId";
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':courses', $courses, PDO::PARAM_STR);
  $stmt->bindParam(':yearId', $yearId, PDO::PARAM_STR);
  $update = $stmt->execute();
  
  if($update) {
    echo json_encode(array('status' => 'success'));
  }
  else {
    echo json_encode(array('status' => 'failed'));
  }
}

/**
 *Function to delete a course from the degree map
 *
 *@param String $courses the updated list of courses for the given quarter
 *@param String $yearId the id for the degree year being edited
 *@param String $quarter the quarter being edited
 */
function removeCourse($courses, $yearId, $quarter)
{
  $sql = "UPDATE year SET $quarter=:courses WHERE id=:yearId";
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':courses', $courses, PDO::PARAM_STR);
  $stmt->bindParam(':yearId', $yearId, PDO::PARAM_STR);
  $update = $stmt->execute();
  
  if($update) {
    echo json_encode(array('status' => 'success'));
  }
  else {
    echo json_encode(array('status' => 'failed'));
  }
}

/**
 *Checks for prereqs in the quarters before a given course
 * @param String $degreeId the id of the degree being searched
 * @param String $course The course being checked against
 * @param String $year the degree year the course is in
 * @param String $quarter the quarter the course is in
 */
function checkMissingPrereqs($degreeId, $course, $year, $quarter)
{
  //Need some sort of check up here to eliminate associate-level prereqs when checking
  //on bachelor-level courses
  //Get prereqs for course
  $courseId = getCourseID($course);
  $prereqs = getPrereqsForCourse($courseId, true);
  $courseLevel = preg_replace("/\D/", "", $course);
  
  //Add prereqs to array to be returned
  $missing = array();
  foreach($prereqs as $prereq) {
    $prereqLevel = preg_replace("/\D/", "", $prereq);
    if(($courseLevel < 300 && $prereqLevel < 300) || ($courseLevel > 300 && $prereqLevel > 300)) {
      $missing[] = $prereq;
    }
  }
  
  //Check for prereqs in previous quarters of same year
  if($quarter === 'winter') {
    $sql = "SELECT fall FROM year WHERE degree_id=:degree_id AND year=:year";
    $db = dbConnect();
    $stmt = $db->prepare($sql);
    $db = null;
    $stmt->bindParam(':degree_id', $degreeId, PDO::PARAM_INT);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($results as $row) {
      $courses = explode(',', $row['fall']);
      foreach($courses as $course) {
        //Check against prereqs
        if(($key = array_search($course, $missing)) !== false) {
          //If a prereq is found, remove from the return list
          unset($missing[$key]);
        }
      }
    }

  } elseif($quarter === 'spring') {
    //Select fall and winter courses from table
    $sql = "SELECT fall, winter FROM year WHERE degree_id=:degree_id AND year=:year";
    $db = dbConnect();
    $stmt = $db->prepare($sql);
    $db = null;
    $stmt->bindParam(':degree_id', $degreeId, PDO::PARAM_INT);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($results as $row) {
      $fall = explode(',', $row['fall']);
      $winter = explode(',', $row['winter']);
      $courses = array_merge($fall, $winter);
      foreach($courses as $course) {
        //Check against prereqs
        if(($key = array_search($course, $missing)) !== false) {
          //If a prereq is found, remove from the return list
          unset($missing[$key]);
        }
      }
    }
  } elseif($quarter === 'summer') {
    $sql = "SELECT fall, winter, spring FROM year WHERE degree_id=:degree_id AND year=:year";
    $db = dbConnect();
    $stmt = $db->prepare($sql);
    $db = null;
    $stmt->bindParam(':degree_id', $degreeId, PDO::PARAM_INT);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($results as $row) {
      $fall = explode(',', $row['fall']);
      $winter = explode(',', $row['winter']);
      $spring = explode(',', $row['spring']);
      $courses = array_merge($fall, $winter, $spring);
      foreach($courses as $course) {
        //Check against prereqs
        if(($key = array_search($course, $missing)) !== false) {
          //If a prereq is found, remove from the return list
          unset($missing[$key]);
        }
      }
    } 
  }
  
  //Now to check against previous years
  if($year > 1 && $year <= 4) {
    $sql = "SELECT fall, winter, spring, summer FROM year WHERE degree_id=:degree_id AND year<:year";
    $db = dbConnect();
    $stmt = $db->prepare($sql);
    $db = null;
    $stmt->bindParam(':degree_id', $degreeId, PDO::PARAM_INT);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($results as $row) {
      $fall = explode(',', $row['fall']);
      $winter = explode(',', $row['winter']);
      $spring = explode(',', $row['spring']);
      $summer = explode(',', $row['summer']);
      $courses = array_merge($fall, $winter, $spring);
      foreach($courses as $course) {
        //Check against prereqs
        if(($key = array_search($course, $missing)) !== false) {
          //If a prereq is found, remove from the return list
          unset($missing[$key]);
        }
      }
    }
    
  }
  
  echo json_encode($missing);
  
}