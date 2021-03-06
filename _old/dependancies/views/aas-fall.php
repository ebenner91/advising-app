 <!-- First year-->
 <!-- Fall Start-->
 <!--Fall Schedule-->

 <div id="aas-fall-start-schedule" class="aas-fall">
	<div class='col-md-8 col-xs-8 col-sm-8'>
		<div class="row">
			<div class='col-md-12 col-xs-12 col-sm-12'>
				<h2>First Year</h2>
			<div class="column fall" id="aas-fall-freshman-fallStart">
 
			<div class="title">
	<p class="column-title">FALL</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-fall-freshman-fallStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>
 
 <!--Winter Schedule-->
<div class="column winter" id="aas-winter-freshman-fallStart">
 
 <div class="title">
	<p class="column-title">WINTER</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-winter-freshman-fallStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>
 
 <!--Spring Schedule-->
 <div class="column spring" id="aas-spring-freshman-fallStart">

<div class="title">
	<p class="column-title">SPRING</p>
	</div>

 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-spring-freshman-fallStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>

<!--Summer Schedule-->

	
	<div class="column summer" id="aas-summer-freshman-fallStart">
 
					<div class="title">
						<p class="column-title">SUMMER</p>
					</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-summer-freshman-fallStart'){
		
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
 <div class="column fall" id="aas-fall-sophmore-fallStart">
 
 <div class="title">
	<p class="column-title">FALL</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-fall-sophmore-fallStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>
 
 <!--Winter Schedule-->
<div class="column winter" id="aas-winter-sophmore-fallStart">
 
 <div class="title">
	<p class="column-title">WINTER</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-winter-sophmore-fallStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>
 
 <!--Spring Schedule-->
 <div class="column spring" id="aas-spring-sophmore-fallStart">

<div class="title">
	<p class="column-title">SPRING</p>
	</div>

 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-spring-sophmore-fallStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>

<!--Summer Schedule-->
	
	<div class="column summer" id="aas-summer-sophmore-fallStart">
 
 <div class="title">
	<p class="column-title">SUMMER</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'aas-summer-sophmore-fallStart'){
		
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