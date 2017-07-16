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
    degree_id: integet storing the foreign key id for the degree. References an id in the degree table.  
)
