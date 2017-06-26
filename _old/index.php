<?php
    //Start a new session with the server
    session_start();

    //If the authentication session variable does not exist, create it
    if(!isset($_SESSION['auth'])){
        $_SESSION['auth'] = false;
    }
	
	//Show login/logout buttons
	if($_SESSION['auth'] != true){
		echo "<a role='button' class='authentication-link btn btn-info' href='login.php'>LOGIN</a>";
	}else{
		echo "<a role='button' class='authentication-link btn btn-info' href='dependancies/php/logout.php'>LOGOUT</a>";
	}
	
	include "dependancies/php/header.php";
	
	/*
	*	@author Stephen King
	*	@created 6/9/2016
	*	@version 1.0
	*
	*	This document is the public facing version of the advising app. The only interaction that should
	*	be allowed in version 1.0 is the login button. Only administrators (faculty/staff) should be
	* 	able to modify anything.
	*
	*	Version 2.0 should merge this and admin so that various elements are only visible depending on the
	* 	user's permissions on login and only a single page is used instead of two. See the trello board
	* 	for more information.
	*/
?>




  <script>
  
  /**
  * This makes selected elements sortable withing all other elements in "connectWith"
  */
  $(function() {
	
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
	/*
	*	This is the draggable course object.
	*/
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
  
  </script>
</head>
<body>
 
 
	<?php include "dependancies/php/nav.php"; ?>
	<?php require "dependancies/db/dbcon.php"; ?>
	<?php require "dependancies/models/CourseModel.php"; ?>
	
	<?php
		//This makes database connections and grabs the course info for the catalog
	?>
  
	<?php $courseModel = new CourseModel(readDatabase()); ?>

    <?php $courseCatalog = $courseModel->getScheduledCourses(); ?>

<div class="container">	
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
  <div class="column-order">
  <?php include "dependancies/views/aas-fall.php"; ?>
  <?php include "dependancies/views/aas-winter.php"; ?>
  <?php include "dependancies/views/aas-spring.php"; ?>
  <?php include "dependancies/views/aas-summer.php"; ?>
  <?php include "dependancies/views/bas-software-fall.php"; ?>
  <?php include "dependancies/views/bas-software-winter.php"; ?>
   <?php include "dependancies/views/bas-network-fall.php"; ?>
  <?php include "dependancies/views/bas-network-winter.php"; ?>
  </div>
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
	
	//Button Manipulation
	var currentId = ".aas-fall";
	var btnStartTarget = "aas-fall-start";
	var btnProgramTarget = "aast-program";
	var currentProgramId = ".aas-class-buttons";
	
	
	
	//Switch between the offered programs
	function toggleScheduledPrograms(clicked_id){
		
		
		
		if(clicked_id != currentId){

					
		
				//Remove current program				
				$(currentId).hide(0, function(){
					
					//Add new program as soon as the old is removed
					$(clicked_id).show();
					currentId = clicked_id;
					
				});				
						
				//console.log("Current Button" + currentId);
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
 
<?php include "dependancies/php/footer.php";?>