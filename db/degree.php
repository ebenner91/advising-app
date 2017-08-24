<?php
/**
 * Green River IT Advising App
 * @author Arnold Koh <arnold@kohded.com>
 * @version 2.0, developed 9/23/16
 * @url http://advisingapp.greenrivertech.net/
 * degree.php
 * Database queries for degree map filtering.
 */

 //Commented out original include statement and replaced with one that works on dev domain
//include '../../db.php';
include_once '/home/advisingapp/db-dev.php';
//Include admin-course-form to reuse functions
include_once 'admin-course-form.php';

//Check if post is sent from ajax call.
if(isset($_POST['type'])) {
  $type = $_POST['type'];

  if(isset($_POST['title'])) {
    $title = $_POST['title'];
  }
  if(isset($_POST['start'])) {
    $start = $_POST['start'];
  }
  if(isset($_POST['number'])) {
    $number = $_POST['number'];
  }

  switch($type) {
    case 'getDegree' :
      getDegree($title, $start);
      break;
    case 'getTitle' :
      getTitle();
      break;
    case 'getStart' :
      getStart($title);
      break;
    case 'getCourse':
      getCourse($number);
      break;
    default:
      break;
  }
}

/**
 * Returns a degree by degree title and quarter start.
 * @param $title The degree title.
 * @param $start The quarter start.
 */
function getDegree($title, $start) {
  $degree = array();
  $years = array();
  $sql = 'SELECT  d.id AS degree_id, y.id, y.year, y.fall, y.winter, y.spring, y.summer
            FROM year y
            INNER JOIN degree d
            WHERE d.id = y.degree_id AND d.title = :title AND d.start = :start
            ORDER BY y.year ASC';

  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':title', $title, PDO::PARAM_STR);
  $stmt->bindParam(':start', $start, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($result as $row) {
    $year = array();
    $degree['id'] = $row['degree_id'];
    $year['yearId'] = $row['id'];
    $year['year'] = $row['year'];
    $year['fall'] = explode(',', $row['fall']);
    $year['winter'] = explode(',', $row['winter']);
    $year['spring'] = explode(',', $row['spring']);
    $year['summer'] = explode(',', $row['summer']);
    $years[] = $year;
  }

  $degree['years'] = $years;

  echo json_encode($degree);
}

/**
 * Returns all distinct degree titles.
 */
function getTitle() {
  $degreeTitle = array();
  $sqlTitle = 'SELECT DISTINCT d.title 
                FROM degree d 
                ORDER BY d.title ASC';

  $db = dbConnect();
  $stmtTitle = $db->prepare($sqlTitle);
  $db = null;
  $stmtTitle->execute();
  $resultTitle = $stmtTitle->fetchAll(PDO::FETCH_ASSOC);

  foreach($resultTitle as $row) {
    $degreeTitle[] = $row['title'];
  }

  echo json_encode($degreeTitle);
}

/**
 * Returns all distinct quarter start.
 * @param $title The degree title.
 */
function getStart($title) {
  $degreeStart = array();
  $fall = 'Fall';
  $winter = 'Winter';
  $winterEvening = 'Winter Evening/Hybrid';
  $spring = 'Spring';
  $summer = 'Summer';
  $sqlStart = 'SELECT DISTINCT d.start 
                FROM degree d 
                WHERE d.title = :title 
                ORDER BY FIELD(d.start, :fall, :winter, :winterEvening, :spring, :summer)';

  $db = dbConnect();
  $stmtStart = $db->prepare($sqlStart);
  $db = null;
  $stmtStart->bindParam(':title', $title, PDO::PARAM_STR);
  $stmtStart->bindParam(':fall', $fall, PDO::PARAM_STR);
  $stmtStart->bindParam(':winter', $winter, PDO::PARAM_STR);
  $stmtStart->bindParam(':winterEvening', $winterEvening, PDO::PARAM_STR);
  $stmtStart->bindParam(':spring', $spring, PDO::PARAM_STR);
  $stmtStart->bindParam(':summer', $summer, PDO::PARAM_STR);
  $stmtStart->execute();
  $resultStart = $stmtStart->fetchAll(PDO::FETCH_ASSOC);

  foreach($resultStart as $row) {
    $degreeStart[] = $row['start'];
  }

  echo json_encode($degreeStart);
}

/**
 * Returns a course by course number.
 * @param $number The course number.
 */
function getCourse($number) {
  $sql = 'SELECT c.id, c.number, c.title, c.description, c.credit 
            FROM course c
            WHERE c.number = :number';

  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  $stmt->bindParam(':number', $number, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $courseId = getCourseID($number);
  $prereqs = getPrereqsForCourse($courseId, true);
  $prereqs = implode(', ', $prereqs);
  
  $quarters = getQuartersForCourse($courseId, true);
  foreach($quarters as &$quarter) {
    $quarter = ucfirst($quarter);
  }
  
  $quarters = array_unique($quarters);
  $quarters = implode(", ", $quarters);

  $course = array();
  $course['id'] = $result['id'];
  $course['number'] = $result['number'];
  $course['title'] = $result['title'];
  $course['description'] = $result['description'];
  $course['credit'] = $result['credit'];
  $course['prereq'] = $prereqs;
  $course['quarter'] = $quarters;
  
  echo json_encode($course);
}

/**
 *Gets course numbers for prereqs
 *
 *@param Array $prereqs Array of course ids
 */
function getPrereqNumbers($prereqs) {
  $sql = "SELECT number FROM course WHERE id = :id";
  
  $db = dbConnect();
  $stmt = $db->prepare($sql);
  $db = null;
  
  $prereqNumbers = array();
  
  foreach($prereqs as $prereq) {
    $stmt->bindParam(':id', $prereq, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $prereqNumbers[] = $result['number'];
  }
  return $prereqNumbers;
}