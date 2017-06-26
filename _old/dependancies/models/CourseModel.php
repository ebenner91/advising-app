<?php
/*
* CourseModel Class
* Author: Stephen King
* Version 2016.4.4.1
*
* This class contains all of the legal queries that can be run on the database for events.
* Any further queries should be added to this class to maintain model/view integrity
*/
?>

<?php
class CourseModel{
    
    protected $db;
    
    public function __construct(PDO $db){
        $this->db = $db;
    }
    
    //This retrieves all courses in the database that have not been scheduled
    public function getAllAvailableCourses(){
        return $this->db->query("
		SELECT course.courseid, course.coursenum, course.title, course.description, course.credits, course.prereqs, scheduled_courses.course_id
		FROM course
		LEFT JOIN scheduled_courses ON scheduled_courses.course_id = course.courseid
		WHERE scheduled_courses.course_id IS NULL
		");
    }
	
	//This retrieves only classes available for given degree period (AAS)
	   public function getAASCourses($startQuarter){
        return $this->db->query("
		    SELECT course.courseid, course.coursenum, course.title, course.description, course.credits, course.prereqs 
			FROM course 
			WHERE courseId NOT IN
				(SELECT scheduled_courses.course_id FROM scheduled_courses
				WHERE SUBSTRING_INDEX(scheduled_courses.current_column, '-', -1) = '" . $startQuarter . "') && SUBSTRING(course.coursenum, -3) < 300
		");
    }
	
		//This retrieves only classes available for given degree period (BAS)
		//It must check to see if no classes are scheduled
		//and if a class is scheduled for the selected program/start quarter but not another
	   public function getBASCourses($programType, $startQuarter){
        return $this->db->query("
		SELECT course.courseid, course.coursenum, course.title, course.description, course.credits, course.prereqs 
			FROM course 
			WHERE courseId NOT IN
				(SELECT scheduled_courses.course_id FROM scheduled_courses
				 WHERE SUBSTRING_INDEX(scheduled_courses.current_column, '-', -1) = '" . $startQuarter . "'
				 && SUBSTRING_INDEX(SUBSTRING_INDEX(scheduled_courses.current_column, '-', -4), '-', 1) = '" . $programType . "')				
				 && SUBSTRING(course.coursenum, -3) >= 300
				
		");
    }
	
    
    //This retrieves only the selected course
    public function getSelectedCourse($quarter, $year){
        return $this->db->query("
		SELECT course_id, year, quarter, program
        FROM scheduled_courses
        ");
    }
    
    //Get all scheduled courses
    public function getScheduledCourses(){
        return $this->db->query("
        SELECT scheduled_courses.course_id, course.coursenum, scheduled_courses.current_column, course.description, course.title, course.courseid, course.prereqs, course.credits
		FROM scheduled_courses
		JOIN course ON course.courseid = scheduled_courses.course_id");
		//WHERE scheduled_courses.current_column = '" . $column . "'");
    }
    
	/*
	* These are all commands that have write/update access to the database.
	* Use extreme caution when editing these!!! Prepared statements will
	* protected from 1st order injections but not from 2nd order. This is
	* typically okay, as 2nd order are insanely difficult to perform.
	* However, care should be taken when adding or modifying prepared
	* statements just in case.
	*/
	
    //Insert course as scheduled
    public function insertCourse($uid, $cid, $column, $completed){
        $stmt = $this->db->prepare("
            INSERT INTO scheduled_courses (uid, course_id, current_column, completed)
             VALUES(:user_id, :course_id, :current_column, :completed)"
        );
        
        //Bindings
        $stmt->bindParam(':user_id', $uid);
        $stmt->bindParam(':course_id', $cid);
        $stmt->bindParam(':current_column', $column);
        $stmt->bindParam(':completed', $completed);
                
        $stmt->execute();
        
        return $stmt->rowCount();
    }
    
	//This moves courses between quarters
	public function rescheduleCourse($currentColumn, $courseId){
		$stmt = $this->db->prepare("
			UPDATE scheduled_courses
			SET current_column = :current_column
			WHERE course_id = :course_id
			"
		);
		
		//Bindings
		$stmt->bindParam(':current_column', $currentColumn);
		$stmt->bindParam(':course_id', $courseId);
		
		$stmt->execute();
		
		return $stmt->rowCount();
		
	}
	
	//This removes the scheduled course and returns it to the catalog
	public function removeCourse($courseId){
		$stmt = $this->db->prepare("
		DELETE FROM scheduled_courses
		WHERE course_id = :course_id
		");
		
		//Bindings
		$stmt->bindParam(':course_id', $courseId);
		
		$stmt->execute();
		
		return $stmt->rowCount();
	}
	
	//This adds a course to the course table
	public function addCourse($courseID, $courseNumber, $courseTitle, $courseDescription, $courseCredits, $coursePrereqs){
		$stmt = $this->db->prepare("
            INSERT INTO course (courseid, coursenum, title, description, credits, prereqs)
			VALUES(:courseID, :courseNumber, :courseTitle, :courseDescription, :courseCredits, :coursePrereqs)
        ");
        
        //Bindings
        $stmt->bindParam(':courseID', $courseID);
        $stmt->bindParam(':courseNumber', $courseNumber);
        $stmt->bindParam(':courseTitle', $courseTitle);
        $stmt->bindParam(':courseDescription', $courseDescription);
		$stmt->bindParam(':courseCredits', $courseCredits);
		$stmt->bindParam(':coursePrereqs', $coursePrereqs);
                
        $stmt->execute();
        
        return $stmt->rowCount();
	}
	
	//This edits an existing course
	public function editCourse($courseID, $courseNumber, $courseTitle, $courseDescription, $courseCredits, $coursePrereqs){
		$stmt = $this->db->prepare("
			UPDATE course 
			SET coursenum = :courseNumber, title = :courseTitle, description = :courseDescription, credits = :courseCredits, prereqs = :coursePrereqs
			WHERE courseid = :courseID
        ");
        
        //Bindings
        $stmt->bindParam(':courseID', $courseID);
        $stmt->bindParam(':courseNumber', $courseNumber);
        $stmt->bindParam(':courseTitle', $courseTitle);
        $stmt->bindParam(':courseDescription', $courseDescription);
		$stmt->bindParam(':courseCredits', $courseCredits);
		$stmt->bindParam(':coursePrereqs', $coursePrereqs);
                
        $stmt->execute();
        
        return $stmt->rowCount();
	}
	
	//This permanently deletes a course from the table
	public function deleteCourse($courseID){
		$stmt = $this->db->prepare("
			DELETE FROM course			
			WHERE courseid = :courseID
        ");
        
        //Bindings
        $stmt->bindParam(':courseID', $courseID);
                
        $stmt->execute();
        
        return $stmt->rowCount();
	}
	
	 public function getAllCourses(){
        return $this->db->query("
		SELECT * 
        FROM course
		ORDER BY length(course.courseid), course.courseid
        ");
    }
	
	//This selects a specific course
	 public function getCourse($courseID){
        return $this->db->query("
		SELECT * 
        FROM course
		WHERE course.courseid = '" . $courseID . "'
        ");
    }
	
}

?>