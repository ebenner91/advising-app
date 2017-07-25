/**
 * File: degree.js
 * Description: Used for the degree select, degree filter, and course modal.
 * Retrieves course data from the database through ajax, then outputs the data
 * to a Handlebars template.
 *
 * @author Arnold Koh <arnold@kohded.com>
 * @version 2.0, developed 9/23/16
 */

const degree = {
  //Saves div elements into variables
  div: {
    courseModalTitle: $('.course-modal-title'),
    courseModalDescription: $('.course-modal-description'),
    courseModalPrereq: $('.course-modal-prereq'),
    courseModalQuarter: $('.course-modal-quarter'),
    degreeForm: $('#degree-form'),
    degreeMap: $('#degree-map'),
    degreeSelectTitle: $('#degree-select-title'),
    degreeSelectStart: $('#degree-select-start'),
    select: $('select')
  },
  //Set up the app to it's beginning state
  init: function () {
    degree.div.degreeMap.hide(); //Hide the degree map
    degree.div.select.material_select(); //Initialize the select inputs using MaterializeCSS
    degree.select.loadDegreeTitles(); //Populate the degree select with titles from database
    degree.submitSearchForm(); //Initalizes function to handle submit button

    degree.div.degreeSelectTitle.change((event) => {
      event.preventDefault();
      degree.select.loadQuarterStartByDegree(event.target.value);
    }); /*Populates the start quarter select box depending on the degree selection whenever the
    degree select is changed */
  },
  //Functions relating to the select inputs
  select: {
    //Get degree titles from the database and populate the degree select
    loadDegreeTitles: function () {
      $.ajax({
        data: 'type=getTitle', //Inform the php script which function we are calling
        dataType: 'json',
        type: 'POST', 
        url: 'db/degree.php',
        success: function (degreeTitles) {
          //Populate quarter start select based on the first degree in the list
          degree.select.loadQuarterStartByDegree(degreeTitles[0]); 

          // Loop through degree titles and append as select option.
          for (let i = 0; i < degreeTitles.length; i++) {
            degree.div.degreeSelectTitle.append($('<option/>', {
              value: degreeTitles[i],
              text: degreeTitles[i]
            }));
          }
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    },
    //Get quarter start options from database based on degree input an populate quarter select
    loadQuarterStartByDegree: function (title) {
      $.ajax({
        /* Inform the php script which function we are calling and
         * pass the degree title */
        data: `type=getStart&title=${encodeURIComponent(title)}`,
        dataType: 'json',
        type: 'POST',
        url: 'db/degree.php',
        success: function (degreeStart) { //Do the following with the retrieved data
          degree.div.degreeSelectStart.empty(); //Clear the start quarter select input

          // Loop through quarter start and append as select option.
          for (let i = 0; i < degreeStart.length; i++) {
            degree.div.degreeSelectStart.append($('<option/>', {
              value: degreeStart[i],
              text: degreeStart[i]
            }));
          }
        },
        complete: function () {
          // Re-initialize select after data loads
          degree.div.select.material_select();
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    }
  },
  submitSearchForm: function () { //Function to handle submit button on degree form
    degree.div.degreeForm.submit((event) => {
      event.preventDefault();
      const title = event.target[1].value; //Save the degree title from the input
      const start = event.target[3].value; //Save the start quarter from the input

      $.ajax({
        /* Inform the php script which function we are calling and
         * pass the degree title */
        data: `type=getDegree&title=${encodeURIComponent(title)}&start=${start}`,
        dataType: 'json',
        type: 'POST',
        url: 'db/degree.php',
        success: function (degreeResult) {
          Handlebars.getTemplate('degree', (template) => { //Get the template for the degree map
            //Add title and start to the json object
            degreeResult.title = title;
            degreeResult.start = start;

            // Undefined until admin logs in, admin.js. For hbs template admin flag.
            try { degreeResult.admin = admin.isLoggedIn; } catch (e) {}

            // Set degree results in Handlebars template the display in html.
            degree.div.degreeMap.html(template(degreeResult));

            // Undefined until admin logs in, admin.js. Initialize sortable.
            try { admin.course.sort(); } catch (e) {}

            degree.div.degreeMap.show(); //Now that the map is populated, show the div
            degree.course.initModalClickEventLoadData(); //Initialize click handler for course map
            degree.course.initModal(); //Initalize the degree details modal
            degree.quarter.resizeCardsToSameHeight();
          });
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });
  },
  course: { //Functions relating to courses on the degree map
    initModalClickEventLoadData: function () { //Click handler for course map
      $('.degree-season-course').click(function (event) {
        event.preventDefault();
        // Get course number data attribute from course li.
        const number = $(this).attr('data-course-number');

        $.ajax({
          /* Inform the php script which function we are calling and
         * pass the course number */
          data: `type=getCourse&number=${number}`,
          dataType: 'json',
          type: 'POST',
          url: 'db/degree.php',
          success: function (course) {
            let credit = ''; //create a credit variable with an empty string
            if (course.credit) {
              credit = ` (${course.credit})`;
            } /* If there is a "credit" value in the course object
               * save it to the credit variable */

            //Create a title String using course number, title, and credits
            const title = `${course.number}: ${course.title}${credit}`; 
            degree.div.courseModalTitle.html(title); //Pass title into the modal
            degree.div.courseModalDescription.html(course.description); //Pass description into the modal

            if (course.prereq) {
              degree.div.courseModalPrereq.html(`Prerequisites: ${course.prereq} - or instructor permission.`);
            } //If the course has prereqs, pass them into the modal
            
            if(course.quarter) {
              degree.div.courseModalQuarter.html(`Quarters offered: ${course.quarter}`);
            } //Pass in the quarters offered
          },
          error: function (xhr, status, error) {
            console.log(xhr.responseText);
          }
        });
      });
    },
    initModal: function () { //Initialize the modal
      $('.degree-course-modal').leanModal({
        dismissible: true, // Can be dismissed by clicking outside modal
        opacity: 0.5, // Opacity of modal background
        in_duration: 400, // Transition in duration
        out_duration: 400, // Transition out duration
        starting_top: '4%', // Starting top style attribute
        ending_top: '10%', // Ending top style attribute
        // ready: function() { }, // Callback for open
        complete: function () { // Callback for close
          // Clear modal text
          degree.div.courseModalTitle.empty();
          degree.div.courseModalDescription.empty();
          degree.div.courseModalPrereq.empty();
        }
      });
    }
  },
  quarter: { //Functions relating to degree quarters on the map
    resizeCardsToSameHeight: function () {
      let cardHeight = 0; //Initialize card height at zero

      // Find the tallest quarter card and set all to the same height.
      $('.degree-season-content').each(function () {
        // heightAdjust is passed in when the admin adds or deletes a course.
        cardHeight = (cardHeight > $(this).height()) ? cardHeight : $(this).height();
      });

      $('.degree-season-content').height(cardHeight); //Set all of the cards to the new height
    }
  }
};

// Function attached to the Handlebars object to compile template files.
Handlebars.getTemplate = function (name, callback) {
  $.ajax({
    ajax: false,
    url: `assets/js/templates/${name}.hbs`,
    success: function (data) {
      if (Handlebars.template === undefined) {
        Handlebars.template = {};
      }
      // Compile template.
      Handlebars.template[name] = Handlebars.compile(data);
      // Callback the template if it exists.
      if (callback) {
        callback(Handlebars.template[name]);
      }
    }
  });
};

$(() => {
  degree.init(); //Run the init function to start up the app
});
