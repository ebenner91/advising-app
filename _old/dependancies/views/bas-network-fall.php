 <!-- First year-->
 <!-- Fall Start-->
 <!--Fall Schedule-->

 <div id="bas-network-fall-start-schedule" class="bas-network-fall">
	<div class='col-md-8 col-xs-8 col-sm-8'>
		<div class="row">
			<div class='col-md-12 col-xs-12 col-sm-12'>
				<h2>First Year</h2>
			<div class="column fall" id="bas-network-fall-junior-fallStart">
 
			<div class="title">
	<p class="column-title">FALL</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'bas-network-fall-junior-fallStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>
 
 <!--Winter Schedule-->
<div class="column winter" id="bas-network-winter-junior-fallStart">
 
 <div class="title">
	<p class="column-title">WINTER</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'bas-network-winter-junior-fallStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>
 
 <!--Spring Schedule-->
 <div class="column spring" id="bas-network-spring-junior-fallStart">

<div class="title">
	<p class="column-title">SPRING</p>
	</div>

 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'bas-network-spring-junior-fallStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>

<!--Summer Schedule-->

	
	<div class="column summer" id="bas-network-summer-junior-fallStart">
 
					<div class="title">
						<p class="column-title">SUMMER</p>
					</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'bas-network-summer-junior-fallStart'){
		
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
 <div class="column fall" id="bas-network-fall-senior-fallStart">
 
 <div class="title">
	<p class="column-title">FALL</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'bas-network-fall-senior-fallStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>
 
 <!--Winter Schedule-->
<div class="column winter" id="bas-network-winter-senior-fallStart">
 
 <div class="title">
	<p class="column-title">WINTER</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'bas-network-winter-senior-fallStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>
 
 <!--Spring Schedule-->
 <div class="column spring" id="bas-network-spring-senior-fallStart">

<div class="title">
	<p class="column-title">SPRING</p>
	</div>

 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'bas-network-spring-senior-fallStart'){
		
		echo "<div class='portlet' current-location='{$row['current_column']}' id='{$row['courseid']}'>
		<div class='portlet-header'>{$row['coursenum']} ({$row['credits']})</div>
		<div class='portlet-content'><h4>{$row['title']}</h4> <p>{$row['description']}</p> <b>Prerequisites:</b> {$row['prereqs']}</div>
		</div>";
		}
	}

 ?>
</div>

<!--Summer Schedule-->
	
	<div class="column summer" id="bas-network-summer-senior-fallStart">
 
 <div class="title">
	<p class="column-title">SUMMER</p>
	</div>
 <?php
 
	$columnList = $courseModel->getScheduledCourses();
 
	foreach($columnList as $row){
		
	if($row['current_column'] == 'bas-network-summer-senior-fallStart'){
		
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