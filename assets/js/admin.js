/**
 * File: admin.js
 * Description: Used for admin functionality.
 *
 * @author Arnold Koh <arnold@kohded.com>
 * @version 2.0, developed 9/23/16
 */

const admin = {
  isLoggedIn: true, //Lets degree.js functions know an admin is logged in
  //Saves div elements into variables
  div: { 
    adminCollapsible: $('#admin-collapsible'),
    adminFormCourseBtns: $('#admin-form-course-btns'),
    adminInputCourseCredit: $('#admin-input-course-credit'),
    adminInputCourseDescription: $('#admin-input-course-description'),
    adminInputCourseNumber: $('#admin-input-course-number'),
    adminInputCoursePrereq: $('#admin-input-course-prereq'),
    adminInputCourseQuarter: $('#admin-input-course-quarter'),
    adminInputCourseTitle: $('#admin-input-course-title'),
    degreeMap: $('#degree-map'),
    degreeSeasonCourses: $('.degree-season-courses'),
    select: $('select')
  },
  init: function () { //Initialize the admin functions in the app
    // Admin forms to add a degree or course.
    admin.div.adminCollapsible.collapsible(); //Initialize collapsible div
    admin.courseForm.autocomplete(); //Initialize autocomplete function in course form
    admin.div.select.material_select(); //Initialize the select inputs using MaterializeCSS
    admin.courseForm.select.loadPrereqTitles(); //Populate the prereq select with titles from database

    // Degree map quarterly courses.
    admin.course.autocomplete(); //Initialize autocomplete in degree map
    admin.course.add(); //Initialize add course function in degree map
    admin.course.delete(); //Initialize delete course function in degree map

    // Admin course form.
    admin.div.adminFormCourseBtns.on('click', '#admin-btn-add-course', () => {
      admin.courseForm.add(event);
    }); //Click handler for add button
    admin.div.adminFormCourseBtns.on('click', '#admin-btn-update-course', () => {
      admin.courseForm.update(event);
    }); //Click handler for update button
    admin.div.adminFormCourseBtns.on('click', '#admin-btn-delete-course', () => {
      admin.courseForm.delete(event);
    }); //Click handler for delete button
  },
  course: { //Functions relating to the degree map courses
    autocomplete: function () { //Autocomplete function for course inputs
      admin.div.degreeMap.on('click', '.admin-new-course-autocomplete', () => {
        $('.admin-new-course-autocomplete').devbridgeAutocomplete({
          autoSelectFirst: true,
          maxHeight: 5000,
          lookup: function (courseInput, done) {
            $.ajax({
              /* Inform the php script which function we are calling and
              * pass the course input */
              data: `type=autocompleteCourse&courseInput=${courseInput}`,
              dataType: 'json',
              type: 'POST',
              url: 'db/admin-course-form.php',
              success: function (courses) {
                const result = {
                  suggestions: courses
                };

                done(result);
              },
              error: function (xhr, status, error) {
                console.log(xhr.responseText);
              }
            });
          }
        });
      });
    },
    sort: function () { //Function to allow admin to reorder courses in degree map
      let yearIdFrom;
      let quarterFrom;
      const quarterCoursesFrom = [];

      $('.degree-season-courses').sortable({
        connectWith: '.degree-season-courses',
        disabled: false,
        dropOnEmpty: true,
        start: function (event, ui) {
          // Get year id and quarter data attribute of From div.
          yearIdFrom = ui.item.parent().parent().parent().parent().parent()
                         .attr('data-degree-year-id');
          quarterFrom = ui.item.parent().attr('data-quarter');
        },
        update: function (event, ui) {
          // Get the From list of quarter courses.
          if (ui.sender) {
            
            $(ui.sender[0].children).each(function () {
              // Add courses to quarterCoursesFrom array
              quarterCoursesFrom.push($(this).attr('data-course-number'));
            });
            // Get year id and quarter data attribute of To div.
            const yearIdTo = ui.item.parent().parent().parent().parent().parent()
                               .attr('data-degree-year-id');
            const quarterTo = ui.item.parent().attr('data-quarter');
            const quarterCoursesTo = [];
  
            // Get the To list of quarter courses.
            $(ui.item.parent()[0].children).each(function () {
              // Add courses to quarterCoursesTo array.
              quarterCoursesTo.push($(this).attr('data-course-number'));
            });
  
            // Save From and To list of quarterly courses.
            $.ajax({
              data: `type=sortCourseToFrom&yearIdFrom=${yearIdFrom}&quarterFrom=${quarterFrom}
              &quarterCoursesFrom=${quarterCoursesFrom}&yearIdTo=${yearIdTo}&quarterTo=${quarterTo}
              &quarterCoursesTo=${quarterCoursesTo}`,
              dataType: 'json',
              type: 'POST',
              url: 'db/admin-degree-map.php',
              error: function (xhr, status, error) {
                console.log(xhr.responseText);
              }
            });
            
            //clear the arrays
            quarterCoursesFrom.length = 0;
            quarterCoursesTo.length = 0;
            
            //Scripts to check for missing prereqs - Still developing
            /*
            var degreeId = $("#degree-title").attr("data-degree-id");
            var course = ui.item.attr("data-course-number");
            var year = ui.item.closest(".degree-season").attr("data-degree-year");
            var quarter = ui.item.closest(".degree-season-courses").attr("data-quarter");
            
            //Testing checkMissingPrereqs function
            $.ajax({
              data: `type=checkMissingPrereqs&degreeId=${degreeId}&course=${course}&year=${year}&quarter=${quarter}`,
              dataType: 'json',
              type: 'POST',
              url: 'db/admin-degree-map.php',
              success: function(missing) {
                if(missing.length > 0) {
                  var message = "Missing prereqs: ";
                  var prereqList = missing.join(', ');
                  message += prereqList;
                  
                  Materialize.toast(message, 4000);
                  ui.item.addClass('red');
                } else {
                  ui.item.removeClass('red');
                }
              },
              error: function (xhr, status, error) {
                console.log(xhr.responseText);
              }
            });*/
            
          } else {
            // Get year id and quarter data attribute of quarter div.
            const yearId = ui.item.parent().parent().parent().parent().parent()
                               .attr('data-degree-year-id');
            const quarter = ui.item.parent().attr('data-quarter');
            const courses = [];
  
            // Get the To list of quarter courses.
            $(ui.item.parent()[0].children).each(function () {
              // Add courses to quarterCoursesTo array.
              courses.push($(this).attr('data-course-number'));
            });
            
            $.ajax({
              data: `type=sortCourseInQuarter&courses=${courses}&yearId=${yearId}&quarter=${quarter}`,
              dataType: 'json',
              type: 'POST',
              url: 'db/admin-degree-map.php',
              error: function (xhr, status, error) {
                console.log(xhr.responseText);
              }
            });
          
          }
          
        }
      }).disableSelection();
    },
    add: function () { //Adds a course to the map
      admin.div.degreeMap.on('click', '.admin-course-add-btn', function (event) { //Click handler for add button
        event.preventDefault();
        const coursesAfterAdd = [];
        const newCourseInput = $(this).siblings('.admin-new-course-autocomplete').val();
        const courseUnorderedList = $(this).parent().parent().siblings('.degree-season-courses');
        const courseListItems = $(this).parent().parent().siblings('.degree-season-courses')
                                       .children();
        const yearId = $(this).parent().parent().parent().parent().parent().parent()
                              .attr('data-degree-year-id');
        const quarter = $(this).parent().parent().siblings().attr('data-quarter');

        courseListItems.each(function () {
          coursesAfterAdd.push($(this).attr('data-course-number'));
        });
        // Add new course to coursesAfterAdd array.
        coursesAfterAdd.push(newCourseInput);

        $.ajax({
          data: `type=addCourse&courses=${coursesAfterAdd}&yearId=${yearId}&quarter=${quarter}`,
          dataType: 'json',
          type: 'POST',
          url: 'db/admin-degree-map.php',
          error: function (xhr, status, error) {
            console.log(xhr.responseText);
          }
        });

        Handlebars.getTemplate('admin-course-add', (template) => {
          // Append Handlebars template of course to unordered list.
          courseUnorderedList.append(template({ course: newCourseInput }));
        });
      });
    },
    delete: function () {
      admin.div.degreeMap.on('click', '.admin-course-delete-btn', function (event) {
        event.preventDefault();
        const coursesAfterDelete = [];
        const courseListItems = $(this).parent().parent().parent().children();
        const yearId = $(this).parent().parent().parent().parent().parent().parent().parent()
                              .attr('data-degree-year-id');
        const quarter = $(this).parent().parent().parent().attr('data-quarter');
        const course = $(this).parent().parent().attr('data-course-number');
        const courseIndex = $(this).parent().parent().index();

        // Add all courses to array without deleted course.
        courseListItems.each(function (index) {
          if (index !== courseIndex) {
            coursesAfterDelete.push($(this).attr('data-course-number'));
          }
        });

        $.ajax({
          data: `type=removeCourse&courses=${coursesAfterDelete}&yearId=${yearId}&quarter=${quarter}`,
          dataType: 'json',
          type: 'POST',
          url: 'db/admin-degree-map.php',
          error: function (xhr, status, error) {
            console.log(xhr.responseText);
          }
        });

        // Remove course from DOM.
        $(this).parent().parent().filter(`[data-course-number="${course}"]`).remove();
      });
    }
  },
  courseForm: { // Admin course form to add/edit pre-populated courses.
    //Functions relating to the select inputs
    select: {
      //Get prereq titles from the database and populate the prereq select
      loadPrereqTitles: function () {
        $.ajax({
          data: 'type=getPrereqs', //Inform the php script which function we are calling
          dataType: 'json',
          type: 'POST', 
          url: 'db/admin-course-form.php',
          success: function (prereqTitles) {
  
            // Loop through prereq titles and append as select option.
            for (let i = 0; i < prereqTitles.length; i++) {
              admin.div.adminInputCoursePrereq.append($('<option/>', {
                value: prereqTitles[i].id,
                text: prereqTitles[i].number
              }));
            } 
            $('select').material_select('destroy');
            $('select').material_select();
            
            //console.log(prereqTitles);
          },
          error: function (xhr, status, error) {
            console.log(xhr.responseText);
          }
        });
      }
    },
    autocomplete: function () {
      admin.div.adminInputCourseNumber.devbridgeAutocomplete({
        autoSelectFirst: true,
        maxHeight: 5000,
        lookup: function (courseInput, done) {
          $.ajax({
            data: `type=autocompleteCourse&courseInput=${courseInput}`,
            dataType: 'json',
            type: 'POST',
            url: 'db/admin-course-form.php',
            success: function (courses) {
              const result = { suggestions: courses };
              done(result);
            },
            error: function (xhr, status, error) {
              console.log(xhr.responseText);
            }
          });
        },
        onSearchStart: function () {
          // Clear values.
          admin.div.adminInputCourseTitle.val('');
          admin.div.adminInputCourseCredit.val('');
          admin.div.adminInputCourseDescription.val('');
          admin.div.adminInputCoursePrereq.val('');
          admin.div.adminInputCourseQuarter.val('');
          $('select').material_select('destroy');
          $('select').material_select();

          admin.div.adminFormCourseBtns.html(
            `<button class="col s12 m4 btn-large waves-effect waves-light green darken-4" id="admin-btn-add-course" type="submit">
              ADD
            </button>`
          );
        },
        onSelect: function (suggestion) {
          $.ajax({
            data: `type=getCourseInfo&courseNumber=${suggestion.value}`,
            dataType: 'json',
            type: 'POST',
            url: 'db/admin-course-form.php',
            success: function (courseInfo) {
              admin.div.adminInputCourseTitle.val(courseInfo.title);
              admin.div.adminInputCourseCredit.val(courseInfo.credit);
              admin.div.adminInputCoursePrereq.val(courseInfo.prereqs);
              admin.div.adminInputCourseQuarter.val(courseInfo.quarters);
              admin.div.adminInputCourseDescription.val(courseInfo.description);
              Materialize.updateTextFields();
              $('select').material_select('destroy');
              $('select').material_select();

              // Change buttons if course exists.
              admin.div.adminFormCourseBtns.html(
                `<button class="col s12 m4 btn-large waves-effect waves-light green darken-4" id="admin-btn-update-course" type="submit">
                UPDATE
                </button>
                <button class="col s12 m4 btn-large waves-effect waves-light red darken-4" id="admin-btn-delete-course" type="submit">
                DELETE
                </button>`
              );
            },
            error: function (xhr, status, error) {
              console.log(xhr.responseText);
            }
          });
        }
      });
    },
    add: function (event) {
      event.preventDefault();
      //Editing note: Changed these from event.target.form[<index>].value to admin.div.<element variable>.val()?
      //const number = event.target.form[0].value;
      const number = encodeURIComponent(admin.div.adminInputCourseNumber.val());
     // const title = event.target.form[1].value;
      const title = encodeURIComponent(admin.div.adminInputCourseTitle.val());
      //const credit = event.target.form[2].value;
      const credit = admin.div.adminInputCourseCredit.val();
      const prereq = admin.div.adminInputCoursePrereq.val();
      const quarter = admin.div.adminInputCourseQuarter.val();
      //const description = event.target.form[6].value;
      const description = encodeURIComponent(admin.div.adminInputCourseDescription.val());
      const id = encodeURIComponent(admin.div.adminInputCourseNumber.val().toLowerCase().replace(/\s/g, '')); // Convert to lowercase and strip spaces.
      
      
      $.ajax({
        data: `type=createCourse&id=${id}&number=${number}&title=${title}&credit=${credit}
        &prereq=${prereq}&quarter=${quarter}&description=${description}`,
        dataType: 'json',
        type: 'POST',
        url: 'db/admin-course-form.php',
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
     
      
    },
    update: function (event) {
      event.preventDefault();
      //const number = event.target.form[0].value;
      const number = encodeURIComponent(admin.div.adminInputCourseNumber.val());
      //const title = event.target.form[1].value;
      const title = encodeURIComponent(admin.div.adminInputCourseTitle.val());
      //const credit = event.target.form[2].value;
      const credit = admin.div.adminInputCourseCredit.val();
      const prereq = admin.div.adminInputCoursePrereq.val();
      const quarter = admin.div.adminInputCourseQuarter.val();
      //const description = event.target.form[4].value;
      const description = encodeURIComponent(admin.div.adminInputCourseDescription.val());

      $.ajax({
        data: `type=updateCourse&number=${number}&title=${title}&credit=${credit}
        &prereq=${prereq}&quarter=${quarter}&description=${description}`,
        dataType: 'json',
        type: 'POST',
        url: 'db/admin-course-form.php',
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      }); 
    },
    delete: function (event) {
      event.preventDefault();
      //const number = event.target.form[0].value;
      const number = admin.div.adminInputCourseNumber.val();
      $.ajax({
        data: `type=deleteCourse&number=${number}`,
        dataType: 'json',
        type: 'POST',
        url: 'db/admin-course-form.php',
        success: function () {
          admin.div.adminInputCourseNumber.val('');
          admin.div.adminInputCourseTitle.val('');
          admin.div.adminInputCourseCredit.val('');
          admin.div.adminInputCoursePrereq.val('');
          admin.div.adminInputCourseQuarter.val('');
          admin.div.adminInputCourseDescription.val('');
          $('select').material_select('destroy');
          $('select').material_select();
          
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    }
  }
};

$(() => {
  admin.init();
});
