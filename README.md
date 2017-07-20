# advising-app - advisingapp.greenrivertech.net
Git repository for GRC Tech Advising App

Database Tables:  
course - Stores info about courses offered (  
    id (Primary Key): Course number converted to lowercase and stripped of spaces,  
    number: VARCHAR storing the catalog number of the course,  
    title: VARCHAR storing the course title,  
    description: text blob storing the course description,  
    credits: VARCHAR storing the number of credits for the course,  
    prereq: VARCHAR storing a decription of the course's prerequisites   
)  

degree - Stores info about degrees offered (  
    id (Primary Key): Auto-incrementing integer storing an id number for the degree,  
    title: VARCHAR storing the title of the degree,  
    start: VARCHAR storing the starting quarter of the degree (Fall, Winter (or Winter Evening/Hybrid), Summer, or Spring)  
)

prereqs - Stores links between courses and their prerequisites (  
    course_id (Primary Key): VARCHAR storing the foreign key id for the course. References an id in the course table,  
    prereq_id (Primary Key): VARCHAR storing the foreign key id for the prerequisite course. References an id in the course table  
)

quarters - Stores combinations of quarters and times (day or night) courses are offered (  
    course_id (Primary Key): VARCHAR storing the foreign key id for the course. References an id in the course table,  
    quarter (Primary Key): VARCHAR storing a quarter the course is offered,  
    time_slot (Primary Key): VARCHAR storing the time (day or night) the course is offered  
)

year - Stores the schedule plan for each year of a degree (  
    id (Primary Key): Auto-incrementing integer storing an id number for the row,  
    year: TinyInt storing the year (1, 2, or 3) for the row,  
    fall: VARCHAR storing a csv list of the courses needed for fall quarter,  
    winter: VARCHAR storing a csv list of the courses needed for winter quarter,  
    spring: VARCHAR storing a csv list of the courses needed for spring quarter,  
    summer: VARCHAR storing a csv list of the courses needed for summer quarter,  
    degree_id: integer storing the foreign key id for the degree. References an id in the degree table.  
)

Backups of Gen ed and BAS Gen Ed description text:
BAS Gen Ed:
Communications Skills (15)
- Engl& 101 (5)
- Engl 126, Engl 127, Engl 128, Cmst& 210, Cmst& 220 or Cmst& 230 (5)
- Engl 335 (5)

Quantitative/Symbolic Reasoning Skills (5)
- Five credits from the list of Quantitative Skills/Symbolic Reasoning courses approved for the AA-DTA Degree. (Math& 141 Precalc I, Math 147 Finite Mathematics, or higher is recommended)

Humanities (10)
- Cmst 338 or Cmst 238 or Any Hum/FA/Engl classes approved for the AA-DTA degree.

Social Sciences (10)
- Ten credits from the list of Social Science courses approved for the AA-DTA.

Natural Science (10)

Technical Electives (20)
- 20 credits of any Computer Science (CS) courses, any Information Technology (IT) courses, or any of the following Mathematics courses: Math& 146 Intro to Statistics, Math 210 Discrete Math, or Math 256 Statistics for Business and Social Science General Education Electives (10)

General Education Electives (10)
- Ten credits from the lists of Humanities/Fine Arts/English, Social Science, or Natural Science courses approved for the AA-DTA degree.

Electives (50)
- Fifty credits from any courses at the 100-level or higher

Gen Ed

Communication (5)
- Cmst& 210: Interpersonal Communication or
- Cmst& 220: Public Speaking or
- Cmst& 230: Small Group Communication or
- Cmst 238: Intercultural Communication

Engl& 101: English Composition I (5)   

Humanities/Science/Social Science (5)
- Phil 111: Technology, Society, and Values or     
- Bus& 101: Introduction to Business or           
- Any Natural Science List A or B from the AA-DTA or           
- Any Social Science from the AA-DTA or             
- Any Humanities class from the AA-DTA

Math (5)
- Math 108: Math for Information Technology or         
- Any Math class Math& 107 or higher.
NOTE: Students who wish to continue on to the BAS IT Network Administration and Security should complete Math 108 or Math 147. Students who wish to continue on to the BAS IT: Software Development should complete Math& 141 or Math 147, or higher.
