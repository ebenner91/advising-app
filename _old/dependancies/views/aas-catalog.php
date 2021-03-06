<div class='container-fluid'>
	<div class="row">
		<div class='col-md-2 col-xs-2 col-sm-2'>
  <?php
	//Retrieve data from database
    $courseModel = new CourseModel(readDatabase());

    //Format data for display
    $courseCatalog = $courseModel->getAASCourses();
  
  
 
	//This is the catalog of classes that can be added to the schedule
 
 echo '<div id="course-catalog">
 
  <div class="title">
	<p class="column-title">CATALOG</p>
	</div>';
 
 foreach($courseCatalog as $row){
  
 
 echo "<div class='portlet' current-location='catalog' id='{$row['courseid']}'>
    <div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
    <div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
	<div class='portlet-preq'></div>
  </div>";
  
 
 }
 echo "</div>";
 ?>
 </div>

 <!--End Course Catalog-->