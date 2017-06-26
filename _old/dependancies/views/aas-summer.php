 <!-- First year-->
 <!--Spring Start-->
 <!--Fall Schedule-->

  <div id="aas-summer-start-schedule" class="aas-summer">
<div class='col-md-8 col-xs-8 col-sm-8'>
	
		<div class="row">
			<div class='col-md-12 col-xs-12 col-sm-12'>
	
				<h2>First Year</h2>
				<div class="column fall" id="aas-fall-freshman-summerStart">
 
 <div class="title">
	<p class="column-title">FALL</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-fall-freshman-summerStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>
 
 <!--Winter Schedule-->
<div class="column winter" id="aas-winter-freshman-summerStart">
 
 <div class="title">
	<p class="column-title">WINTER</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-winter-freshman-summerStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>
 
 <!--Spring Schedule-->
 <div class="column spring" id="aas-spring-freshman-summerStart">

<div class="title">
	<p class="column-title">SPRING</p>
	</div>

 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-spring-freshman-summerStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>

<!--Summer Schedule-->

	
	<div class="column summer" id="aas-summer-freshman-summerStart">
 
					<div class="title">
						<p class="column-title">SUMMER</p>
					</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-summer-freshman-summerStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
	</div>
	</div>
	</div>

 <!-- end first year -->

 
 <!-- Second Year-->
 <!--Fall Schedule-->

<div class="row">
<div class='col-md-12 col-xs-12 col-sm-12'>
 <h2>Second Year</h2>
 <div class="column fall" id="aas-fall-sophmore-summerStart">
 
 <div class="title">
	<p class="column-title">FALL</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-fall-sophmore-summerStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>
 
 <!--Winter Schedule-->
<div class="column winter" id="aas-winter-sophmore-summerStart">
 
 <div class="title">
	<p class="column-title">WINTER</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-winter-sophmore-summerStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>
 
 <!--Spring Schedule-->
 <div class="column spring" id="aas-spring-sophmore-summerStart">

<div class="title">
	<p class="column-title">SPRING</p>
	</div>

 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-spring-sophmore-summerStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>

<!--Summer Schedule-->
	
	<div class="column summer" id="aas-summer-sophmore-summerStart">
 
 <div class="title">
	<p class="column-title">SUMMER</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-summer-sophmore-summerStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>
 </div>
 </div>
 </div>
 </div>