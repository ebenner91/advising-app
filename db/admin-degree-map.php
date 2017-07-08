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
include "/home/advisingapp/db-dev.php";

//Check if post is sent from ajax call.
if(isset($_POST['type'])) {
  $type = $_POST['type'];
  
  // sortCourse
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
  
  // addCourse, deleteCourse
  if(isset($_POST['courses']) || isset($_POST['yearId']) || isset($_POST['quarter'])) {
    $courses = $_POST['courses'];
    $yearId = $_POST['yearId'];
    $quarter = $_POST['quarter'];
  }
  
  switch($type) {
    case 'sortCourse' :
      sortCourse($yearIdFrom, $quarterFrom, $quarterCoursesFrom, $yearIdTo, $quarterTo, $quarterCoursesTo);
      break;
    case 'addCourse' :
      addCourse($courses, $yearId, $quarter);
      break;
    case 'deleteCourse' :
      deleteCourse($courses, $yearId, $quarter);
      break;
    default:
      break;
  }
}

/**
 *Function to update the course order in the degree map
 *
 *@param String $yearIdFrom the id of the degree year the course is being moved from
 *@param String $quarterFrom the quarter the course is being moved from
 *@param String $quarterCoursesFrom the new list of courses for the quarter the course was moved from
 *@param String $yearIdTo the year the course is being moved to
 *@param String $quarterTo the quarter the course is being moved to
 *@param String $quarterCoursesTo the updated list of courses for the quarter the course was moved to
 */
function sortCourse($yearIdFrom, $quarterFrom, $quarterCoursesFrom, $yearIdTo, $quarterTo, $quarterCoursesTo) {
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
 *Function to add a course to the degree map
 *
 *@param String $courses the updated list of courses for the given quarter
 *@param String $yearId the id for the degree year being edited
 *@param String $quarter the quarter being edited
 */
function addCourse($courses, $yearId, $quarter) {
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
function deleteCourse($courses, $yearId, $quarter) {
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

?>