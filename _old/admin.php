<?php
    //Start a new session with the server
    session_start();

    //If the authentication session variable does not exist, create it
    if(!isset($_SESSION['auth'])){
        $_SESSION['auth'] = false;
    }

	
	//if the user isn't authorized to make new events, kick them back to the home page
   if($_SESSION['auth'] != true){
    echo '<script>window.location = "login.php";</script>';
   }
   //logout button
	echo "<a role='button' class='authentication-link btn btn-info' href='dependancies/php/logout.php'>LOGOUT</a>";
   
	//Course tool
	echo "<a role='button' class='authentication-link btn btn-info' href='coursetool.php'>EDIT COURSES</a>";
		
	include "dependancies/php/header.php";
	
	/*
	*	@author Stephen King
	*	@created 6/9/2016
	*	@version 1.0
	*
	*	This document controls all aspects of adding and removing classes from the advisor.
	*	All functional php scripts are called here, so any changes will likely need to between
	* 	updated here as well. Currently the code is extremely redundant, owing to strict time
	*	constraints on MVP delivery. See the trello board for tasks to revise this tool and
	* 	remove redundancy.
	*/
?>

  <script>
  
  /**
  * This makes selected elements sortable within all other elements in "connectWith"
  */
  $(function() {
	$( ".fall, .summer, .winter, .spring, #course-catalog" ).sortable({			
		dropOnEmpty: true,
		connectWith: ".fall, .summer, .winter, .spring, #course-catalog",
		cancel: "p.column-title",
		handle: ".portlet-header",
		cancel: ".portlet-toggle",
		cursor: "all-scroll",
		placeholder: "portlet-placeholder ui-corner-all",
	
		stop: function(event,ui){ExecuteOnDrop($(ui.item), $(ui.item).parent())}
    });
	
	
	
	//Open and close function for modal window
	function openModal(name) {
    $( "#dialog-message" ).dialog({
		title: name,
      modal: true,
	  width: 600,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
    });
	
  }
	
    $( ".portlet" )
      .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
      .find( ".portlet-header" )
        .addClass( "ui-widget-header ui-corner-all" )
        .prepend( "<span class='ui-icon ui-icon-search portlet-toggle'></span>");
 
    $( ".portlet-toggle" ).click(function(event) {
      var icon = $( this );
      //icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
	  
      var desc = icon.closest( ".portlet" ).find( ".portlet-content" ).html();
	  var name = icon.closest( ".portlet" ).find( ".portlet-header" ).text();
	  $("#class-modal").html(desc);
	  //var d = $('#dialog);
	  //d.data('title.dialog', name);
	 
	  openModal(name);
    });
  });
  
  /**
  * This function is responsible for determining which queries to use.
  */
  function ExecuteOnDrop(item, parent){
  
  var classType = item.attr("class");
  var id = item.attr("id");
  var column = item.attr("current-location");
  var parenta = parent.attr("id");
  
		//If the course is dragged into a quarter column, set it to have the
		//proper column id. Otherwise, remove the column id and set it to a 
		//catalogued course (in the unused course list)
		if(column == "catalog" && parent.hasClass("column")){
			item.attr("current-location", parent.attr("id"));
			item.addClass(parent.attr(id));
			//alert('dependancies/models/UpdateSchedule.php?coursenum=' + id + "&column=" + parent.attr("id"));
			$.get('dependancies/models/UpdateSchedule.php?coursenum=' + id + "&column=" + parent.attr("id"));
			//return false;
			
			
		//if the class is moved to another quarter
		}else if(item.attr("current-location") != "catalog" && parent.hasClass("column") && item.attr("current-location") != parent.attr("id")){
			item.attr("current-location", parent.attr("id"));
			$.get('dependancies/models/RescheduleCourse.php?column=' + parent.attr("id") + '&id=' + id);
			//alert('dependancies/models/UpdateSchedule.php?column=' + parent.attr("id") + '&id=' + id);
			
		//if the class is removed from the schedule
		}else if(item.attr("current-location") != "catalog" && parent.is("#course-catalog")){
			item.attr("current-location", "catalog");
			//document.location.href = 'dependancies/models/RemoveCourse.php?id=' + id;
			$.get('dependancies/models/RemoveCourse.php?id=' + id);
			//alert('dependancies/models/RemoveCourse.php?id=' + id);
			
		}

	}
	
	
	//These variables control which buttons are selected and what they select
	var currentId = ".aas-fall";
	var btnStartTarget = "aas-fall-start";
	var btnProgramTarget = "aast-program";
	var currentProgramId = ".aas-class-buttons";
	
	
	
	//Switch between the offered programs
	function toggleScheduledPrograms(clicked_id){
		
		
		//If the user did not click a button that is already selected
		if(clicked_id != currentId){

					
		
				//Remove current program				
				$(currentId).hide(0, function(){
					
					//Add new program as soon as the old is removed
					$(clicked_id).show();
					currentId = clicked_id;
					
				});				
						
		}
			
	};
	
	//Load the associated button group for the current view
	function toggleStartButtons(clicked_id, defaultView, btnID){
		
		
		
		//if the button is not already active
		if(clicked_id != currentProgramId){
			
			
			
			//Remove current butten set
			$(currentProgramId).hide(0, function(){
				
				//Add new button set after removing the first
				$(clicked_id).show();
				currentProgramId = clicked_id;
							
				//Switch the currently active button			
				toggleScheduledPrograms(defaultView);
				
				//Clear currently selected buttons
				$('.btn-start').removeClass('btn-info').addClass('btn-primary');
				
				//Turn on new default button
				$("#" + btnID).addClass('btn-info');
				btnStartTarget = btnID;
				
				
				//console.log("Current Program" + defaultView);
			});
		}
	};
	
  </script>
</head>
<body>
  
	<?php include "dependancies/php/nav.php"; ?>
	<?php require "dependancies/db/dbcon.php"; ?>
	
	<?php require "dependancies/models/CourseModel.php"; 
	
		//Retrieve data from database
		$courseModel = new CourseModel(readDatabase());
	?>
	
	<?php
		//This is extremely redundant code. See the trello board for more information.
		//These documents should be concentrated into a single column object.
	?>
<div class='container-fluid'>
<div class="col-md-2 col-xs-2 col-sm-2">
	<div class="row">
		<div class="col-md-2 col-xs-2 col-sm-2">
			<?php include "dependancies/views/catalog-aas-fall.php"; ?>
			<?php include "dependancies/views/catalog-aas-winter.php"; ?>
			<?php include "dependancies/views/catalog-aas-spring.php"; ?>
			<?php include "dependancies/views/catalog-aas-summer.php"; ?>
			<?php include "dependancies/views/catalog-bas-software-fall.php"; ?>
			<?php include "dependancies/views/catalog-bas-software-winter.php"; ?>
			<?php include "dependancies/views/catalog-bas-network-fall.php"; ?>
			<?php include "dependancies/views/catalog-bas-network-winter.php"; ?>
		</div>
	</div>
	</div>
  
  <div class="col-md-10 col-xs-10 col-sm-10 col-offset-4">
  
  <div class="row">
  <div class="col-md-8 col-xs-8 col-sm-8 col-offset-4">
		  <button id="aast-program" class="btn-program btn btn-info" onClick="return toggleStartButtons('.aas-class-buttons', '.aas-fall', 'aas-fall-start')">AAS-T IT Systems</button>
		  <button id="bas-software-program" class="btn-program btn btn-primary" onClick="toggleStartButtons('.bas-software-class-buttons', '.bas-software-fall', 'bas-software-fall-start')">BAS Software Development</button>
		  <button id="bas-network-program" class="btn-program btn btn-primary" onClick="toggleStartButtons('.bas-network-class-buttons', '.bas-network-fall', 'bas-network-fall-start')">BAS Networking and Security</button>
  </div>
 </div>
 <br>
<div class="row aas-class-buttons">
	<div class="col-md-8 col-xs-8 col-sm-8 col-offset-4">
		  <button id="aas-fall-start" class="btn-start btn btn-info" onClick="toggleScheduledPrograms('.aas-fall')">Fall Start</button>
		  <button id="aas-winter-start" class="btn-start btn btn-primary" onClick="toggleScheduledPrograms('.aas-winter')">Winter Start</button>
		  <button id="aas-spring-start" class="btn-start btn btn-primary" onClick="toggleScheduledPrograms('.aas-spring')">Spring Start</button>
		  <button id="aas-summer-start" class="btn-start btn btn-primary" onClick="toggleScheduledPrograms('.aas-summer')">Summer Start</button>
	</div>
</div>

<div class="row bas-software-class-buttons">
	<div class="col-md-8 col-xs-8 col-sm-8 col-offset-4">
		  <button id="bas-software-fall-start" class="btn-start btn btn-primary" onClick="toggleScheduledPrograms('.bas-software-fall')">Fall Start</button>
		  <button id="bas-software-winter-start" class="btn-start btn btn-primary" onClick="toggleScheduledPrograms('.bas-software-winter')">Winter Evening Start</button>		  
	</div>
</div>

<div class="row bas-network-class-buttons">
	<div class="col-md-8 col-xs-8 col-sm-8 col-offset-4">
		  <button id="bas-network-fall-start" class="btn-start btn btn-primary" onClick="toggleScheduledPrograms('.bas-network-fall')">Fall Start</button>
		  <button id="bas-network-winter-start" class="btn-start btn btn-primary" onClick="toggleScheduledPrograms('.bas-network-winter')">Winter Evening Start</button>
	</div>
</div>
</div>
  
  
  <?php
		//This is extremely redundant code. See the trello board for more information.
		//These documents should be concentrated into a single column object.
	?>
  
  <?php include "dependancies/views/aas-fall.php"; ?>
  <?php include "dependancies/views/aas-winter.php"; ?>
  <?php include "dependancies/views/aas-spring.php"; ?>
  <?php include "dependancies/views/aas-summer.php"; ?>
  <?php include "dependancies/views/bas-software-fall.php"; ?>
  <?php include "dependancies/views/bas-software-winter.php"; ?>
   <?php include "dependancies/views/bas-network-fall.php"; ?>
  <?php include "dependancies/views/bas-network-winter.php"; ?>
  
  </div>
 
 <!--Modal Stuff-->
	<div id="dialog-message" title="Class Information">
		<div id="class-modal"></div>
	</div>
 
<script>
//Hide everything but aas-fall-start on document load
	$(document).ready(function(){
		
		//Show default schedule
		$(".aas-fall").show();


				//If Start date is clicked
				$(".btn-start").click(function(){

					//Change current button to inactive										
					$('#' + btnStartTarget).removeClass("btn-info").addClass("btn-primary");
				
					btnStartTarget = $(this).attr("id");

					//Change new button to active
					$('#' + btnStartTarget).removeClass("btn-primary").addClass("btn-info");
				});
				
				//If program button is clicked
				$(".btn-program").click(function(){

					//Change current button to inactive										
					$('#' + btnProgramTarget).removeClass("btn-info").addClass("btn-primary");
				
					btnProgramTarget = $(this).attr("id");

					//Change new button to active
					$('#' + btnProgramTarget).removeClass("btn-primary").addClass("btn-info");
					
					
				});
	});
	
</script>
 
<?php include "dependancies/php/footer.php";?>