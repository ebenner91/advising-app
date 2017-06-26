-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 20, 2016 at 04:09 AM
-- Server version: 5.5.51-38.2
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `advising_app_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseid` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `coursenum` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `credits` tinyint(1) NOT NULL DEFAULT '5',
  `prereqs` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseid`, `coursenum`, `title`, `description`, `credits`, `prereqs`) VALUES
('it114', 'IT 114', 'PC Repair Technician', 'An entry level course for PC support technicians. Covers entry level PC hardware and software.  A hands-on technical troubleshooting course. Includes many of the objectives for the CompTIA A+ exam.', 7, 'READ 094 or Instructor permission'),
('it141', 'IT 141', 'Customer Service and Work Environment for IT Professionals', 'Focuses on the knowledge and skills required to be a part of a successful help-desk tea. Topics include communication skills, writing skills, telephone skills, techniques for managing customer expectations, understanding customer behavior, working as part of a team, and minimizing stress in the work environment. Covers interviewing and preparing for the job search experience in the IT field. Prepares students to do job searches, prepares resumes and cover letters, and to dress professionally for the work environment. Uses taped practice interview sessions to improve interviewing skills. Students learn proper e-mail techniques and meeting etiquette. ', 4, 'READ 094 or Instructor permission'),
('it135', 'IT 135', 'Introduction to Network Security', 'Provides students with a broad foundation of network security knowledge. Topics include security fundamentals, overview of cryptography,security policies and procedures, common types of attacks, and how to implement network security\r\nmeasures.', 5, 'IT 114 or Instructor permission'),
('it201', 'IT 201', 'Fundamental Database Design', 'Students analyze real world scenarios, organize\r\ndata into relational tables for storage, and query\r\ninformation for reporting through the use of a\r\ndatabase management system (DBMS). Focuses\r\non the industry standard Structured Query\r\nLanguage (SQL) as the means to create, modify,\r\nand maintain database tables, queries, views,\r\nand constraints. Students learn how to use the\r\nenhanced entity relationship (EER) data model to\r\nidentify entities, stakeholders, and processes of\r\nan organization or business. In addition, students\r\nlearn about how applications such as desktop\r\ncomputer programs, web sites, and mobile device\r\napplications access databases to retrieve and\r\nstore information. Students practice their database\r\ndesign skills through hands-on exercises and labs.', 5, ''),
('it131', 'IT 131', 'Networking Infrastructure Fundamentals', 'Introduces networking to students who are\r\ninterested in a career managing routers and\r\nswitches. Topics include TCP/IP and OSI modules,\r\nsubnetting, protocols, network applications,\r\nswitching and routing fundamentals, and an\r\nintroduction to configuring Cisco routers and\r\nswitches.', 5, 'IT 114 or Instructor permission'),
('it160', 'IT 160', 'Microsoft Windows (Current Version) Server\r\nImplementation', 'Provides students with the knowledge and skills\r\nnecessary to install and configure Microsoft\r\nWindows (current version) Server to create file,\r\nprint, web, and Terminal servers', 5, 'IT 114 or Instructor permission'),
('it190', 'IT 190', 'Linux Administration', 'Provides hands-on experience in installing and\r\nconfiguring a Linux operating system. Presents\r\nprincipal Linux concepts including essential\r\ncommands and the command line, file systems,\r\nkernel compilation, basic user security, and\r\nan introduction to Internet-related services', 5, 'IT 101 or IT 114 or Instructor''s permission'),
('it102 ', 'IT 102 ', 'Intro to Programming', 'Introduces programming. Covers procedural programming (methods, parameters, return values), basic control structures (sequence, if/then/else, for loop, while loop), file processing, arrays, and introduces defining objects.', 5, 'MATH 097 or Instructor''s permission '),
('it210', 'IT 210', 'Managing Cisco Routers and Switches', 'Focuses on the knowledge and skills to implement and configure switching and routing using Cisco products. Topics include device configuration, virtual local area networks (VLANs), routing protocols, and wide area networking (WAN) technologies. ', 5, 'IT 131 or Instructor''s permission'),
('it121', 'IT 121', 'Introduction to HTML', 'Students learn the most important topics of Hypertext Markup Language (HTML), from the basics of creating web pages with graphics and links using tables, and controlling page layout with frames, to more advanced topics, including cascading style sheets, programming with JavaScript and JavaScript objects and events, and creating a multimedia web page with forms.', 5, 'IT 101 or Instructor''s permission'),
('it240', 'IT 240', 'Manage Microsoft Windows (Current Version) Network Environment', 'Gives students the ability to administer support, and troubleshoot information systems that incorporate Microsoft windows (current version). ', 5, 'IT 131 or Instructor''s permission'),
('it243', 'IT 243', 'Advanced Linux Administration-TCP/IP', 'Covers advanced Linux administration topics, including web services, DHCP, DNS, LDAP, SSH, routing, SMTP, NFS, and shell scripting. ', 5, 'IT 190 or Instructor''s permission'),
('it245', 'IT 245', 'Implementing and Administering Directory Services', 'Provides students with the knowledge and skills necessary to install, configure, and administer directory services. Focuses on performing tasks that are required to centrally manage users'' computers and resources.', 5, 'IT 160 or Instructor''s permission'),
('it220', 'IT 220', 'Programming II', 'Examines programming using traditional and visual development environments to learn event-driven object-oriented design.', 5, 'IT 102'),
('it344', 'IT 344', 'Virtualization and Storage', 'Introduces and applies the concepts of server desktop, and application virtualization, cloud computing, and storage area networks (SANs).', 5, 'Admission into the BAS in IT program and instructor''s permission.'),
('it335', 'IT 335', 'Network Security Foundations and Policies', 'Introduces information and business security, security laws. Covers a variety of security topics that are integral to today''s information security professionals, including access control, cryptography, and security architecture and design.', 5, 'Admission into the BAS in IT program and instructor''s permission.'),
('it385', 'IT 385', 'Scripting for Windows and Linux', 'Introduces both the PowerShell scripting language for Windows and the BASH shell used as an interface to the Linux operating system kernel. Builds on the student''s existing programming skills, enabling students to write, test, and execute complex administrative scripts for the Windows and Linux operating systems.', 5, 'Admission into the BAS in IT program and instructor''s permission.'),
('it310', 'IT 310', 'Routing and Switching in the Enterprise', 'Familiarizes students with the equipment applications and protocols installed in enterprise networks, with a focus on switched networks, IP Telephony requirements, and security. Introduces advanced routing protocols such as Enhanced Interior Gateway Routing Protocol (EIGRP) and Open Shortest Path First (OSPF) Protocol. Hands-on exercises include configuration, installation, and troubleshooting.', 5, 'Admission into the BAS in IT program and instructor''s permission.'),
('it340', 'IT 340', 'Network Security and Firewalls', 'Equips students with the knowledge and skills needed to prepare for entry-level network security specialist careers. This course is a hands-on, career-oriented e-learning solution that emphasizes practical experience. Various types of hands-on labs provide practical experience, including procedural and trouble-shooting labs, skills integration challenges, and model building.', 5, 'Admission into the BAS in IT program and instructor''s permission.'),
('it360', 'IT 360', 'Introduction to Computer Forensics and Vulnerability Assessment ', 'In this introductory course, students learn how to set up a forensics lab, how to acquire the necessary tools, how to conduct the investigation, and prepare for the subsequent digital analysis. In addition, students learn the basic skills of identifying network vulnerabilities, and some of the tools that are used to perform vulnerability analysis.', 5, 'Admission into the BAS in IT program and Instructor''s permission.'),
('it390', 'IT 390', 'Mobile Devices and Wireless Networking in Enterprise', 'Introduces the use of wireless networking and mobile devices in an enterprise environment including connectivity, management configuration, and security of both corporate and personal devices.', 5, 'Admission into the BAS in IT program and Instructor''s permission.'),
('it410', 'IT 410', 'Designing and Supporting Computer Networks', 'Uses a variety of case studies and role-playing exercises, which include gathering requirements, designing basic networks, establishing proof-of-concept, performing project management tasks, lifecycle services including upgrades, competitive analyses, and system integration.', 5, 'Admission into the BAS in IT program and IT 310 and instructor''s permission'),
('it460', 'IT 460', 'Threat Analysis', 'Provides the student with the ethical hacking knowledge to conduct a threat assessment, secure a network across popular platforms and operating systems, understand various types of threats, intrusion detection systems, and establish auditing and monitoring systems for vulnerabilities and threats without affecting performance.', 5, 'Admission into the BAS in IT program, IT 360 and IT 385, and instructor''s p'),
('it490', 'IT 490', 'Capstone: Network/Security', 'Students work in teams to plan, implement, secure and document a complete network solution for a real or simulated company. Students implement a proof of concept network and present their design and outcomes to an audience.', 5, 'Admission into the BAS in IT program, BUS 340, ENGL 335, and completion of at least 40 credits of up'),
('it301 ', 'IT 301', 'Systems Programming', 'Introduces students to computer systems from the perspective of a                                                                   \r\nprogrammer. Focus on understanding how hardware, operating systems, and                                                             \r\ncompilers affect the performance of software. Topics cover data                                                                     \r\nrepresentation, assembly and machine-level representation of high-level                                                             \r\nlanguage programs, the memory hierarchy, linking, exceptions, interrupts,                                                           \r\nprocesses and signals, virtual memory, and system-level I/O.', 5, 'CS 131 or CS 141; and admission into a bachelor''s degree program.'),
('it305', 'IT 305', 'Web Development Frameworks', 'Students build web sites using one or more of the major web development                                                             \r\nframeworks (e.g. Node.js, ASP.NET, Rails) and evaluate strengths and                                                                \r\nlimitations. Security is examined in each tier. Focus on technology                                                                 \r\nintegration, testing, and maintaining a separation of concerns between                                                              \r\ntiers. Survey of major cloud computing providers, their services, and                                                               \r\ntheir programming interfaces.', 5, 'CS 132 or CS 145; and admission into a bachelor''s degree program.'),
('it328', 'IT 328', 'Full Stack Web Development', 'Continuation of IT 305. Examines design, integration, debugging, and                                                                \r\ntesting in each layer of the web development stack. Topics include                                                                  \r\nresource management in the server environment, modeling of application and                                                          \r\ndomain logic using object-oriented design patterns, integration with                                                                \r\ndatabases using object-relational mapping, use of NoSQL data stores,                                                                \r\napplication of the Model-View-Controller software pattern, and integration                                                          \r\nwith third-party software.', 5, 'IT 305'),
('it333', 'IT 333', 'Data Structures and Algorithm Analysis', 'Students store and organize data in data structures such as lists, stacks,                                                          \r\nqueues, trees, hash tables, heaps, and graphs; compare algorithm design                                                             \r\ntechniques such as the greedy method, divide and conquer, dynamic                                                                   \r\nprogramming, and backtracking; analyze runtime performance using                                                                    \r\nasymptotic (big O) notation and worst-case analysis.', 5, 'CS 132 or CS 145; and admission into a bachelor''s degree program.'),
('it355', 'IT 355', 'Agile Development Methods', 'Technical practices include test driven development (unit testing),                                                                 \r\ncontinuous integration, refactoring, pair programming, kanban boards, and                                                           \r\nsimple design. Focuses on unit testing, functional testing, and acceptance                                                          \r\ntesting and understanding the relationship between requirements,                                                                    \r\nverification, and validation. Exposure to refactoring techniques. ', 5, 'IT 328'),
('it372', 'IT 372', 'Debugging, Maintenance, and Evolution', 'Defect analysis and resolution is a process where software defects are                                                              \r\nidentified, replicated, evaluated, and classified before repair, testing,                                                           \r\nand release. Tools used include bug/defect tracking software, source code                                                           \r\ncontrol systems, and regression testing suites. Exposure to defect                                                                  \r\nmanagement practices such as triage and risk assessment. Students learn to                                                          \r\nupgrade an existing system without changing existing functionality.', 5, 'IT 328'),
('it405', 'IT 405', 'Mobile Development Frameworks', 'Develop mobile (smartphone and tablet) apps using both native (e.g. iOS and Android) and cross platform frameworks. Compare the strengths and limitations of each platform and of each development framework. Topics include submission to the app store, deployment within an organization, licensing and pricing models, updates, scalability, and security and privacy issues. ', 5, ''),
('it426', 'IT 426', 'Collaborative Design', 'Software developers collaborate with clients, interaction designers, and end-users to design user interfaces, while working with technical team members to design the internal architecture and components of the software. Topics include prototyping, usability, design notations, design patterns, reuse, and design for change. Emphasis on design communication, design integrity, design tradeoffs, and negotiation. ', 5, 'IT 328'),
('it434', 'IT 434', 'Secure Development Practices', 'Information security is the practice of defending information from unauthorized access, use, disclosure, or destruction. Presents a holistic approach to addressing security in the entire software development lifecycle, not just as an afterthought. Topics include security as a non-functional requirement, security in multi-tier software architectures, secure coding practices, and testing techniques. ', 5, ''),
('it485', 'IT 485', 'Product Initiation and Design', 'First of two capstone project courses. Technical team members partner with business team members and end users/customers to develop a product or service concept. Technical team uses Scrum for project management while reconciling it with the business team''s use of traditional project management techniques. ', 5, ''),
('it486', 'IT 486', 'Product Construction and Deployment ', 'Second of two capstone project courses. Technical teams use an Application Lifecycle Management tool, with bug tracking. Practices continuous integration techniques using version control system. Produces production-quality code. Delivers or deploys the product in regularly scheduled release cycles. Students present their products to a community of peers. ', 5, ''),
('bus340', 'BUS 340', 'Project Management', 'Examines the theories and best practices for completing projects on time,                                                           \r\non budget, and to specification. Students learn to apply knowledge and                                                              \r\nskills to effectively initiate, plan, execute, and complete projects.                                                               \r\nSoftware-based project management tools are discussed. Course aligns with                                                           \r\ncurrent PMBOK Guide.', 5, 'Admission into a Bachelor''s program and instructor''s permission. '),
('engl335', 'ENGL 335', 'Advanced Technical Writing', 'Prepare students to communicate effectively in a professional environment.                                                          \r\nStudents become familiar with the processes, forms, and styles of                                                                   \r\ntechnical writing as they create various documents, including instructions,                                                         \r\n proposals, and discipline-specific and/or client-based research projects.                                                          \r\nEmphasizes the purpose and audience, as well as clarity, concision, and                                                             \r\ndocument design.', 5, 'Admission into a bachelor''s program; ENGL 101, and instructor''s permission.'),
('phil412', 'PHIL 412', 'Professional Ethics\r\n', 'Provides an advanced approach to ethical issues across the professions.                                                             \r\nTopics include intellectual property rights and piracy, truth-telling vs.                                                           \r\nwell-meaning deception, privacy and confidentiality, conflicts of interest                                                          \r\nand loyalty, self-regulation, and whistle-blowing.', 5, 'Admission into a Bachelor''s program; ENGL 101, and instructor''s permission.'),
('cmst338', 'CMST 338', 'Organizational Diversity', 'Explores and analyzes the issues, challenges and opportunities related to                                                           \r\nchanging demographics and increasing diversity in the workplace. Through                                                            \r\nintercultural communication theories, concepts and principles, the course                                                           \r\nexamines ways in which challenges of effective communication in a diverse                                                           \r\nworkplace can be identified and work to develop tools and skills to                                                                 \r\nimprove communication competency in these situations.', 5, 'Admission into a Bachelor''s program; ENGL 101, and instructor''s permission.'),
('it236', 'IT 236', 'CompTIA Advanced Security Practitioner Cert Prep\r\n', 'Introduce students to the fundamentals of computer security and cryptography.  Topics include network security; compliance and operational security; threats and vulnerabilities; applications, data, and host security; access control and identity management; and cryptography.  Students learn fundamental network security analysis methods.', 5, ''),
('it219', 'IT 219', 'Programming I ', 'Introduces students to problem solving methods, algorithm development and object-oriented design. Students will design, implement, document and debug programs using an object-oriented programming language.', 5, ''),
('it454', 'IT 454', '', '', 5, '');

-- --------------------------------------------------------

--
-- Table structure for table `scheduled_courses`
--

CREATE TABLE IF NOT EXISTS `scheduled_courses` (
  `scid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `course_id` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `current_column` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `completed` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `program` char(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `scheduled_courses`
--

INSERT INTO `scheduled_courses` (`scid`, `uid`, `course_id`, `current_column`, `completed`, `program`) VALUES
(51, 1, 'it114', 'aas-fall-freshman-fallStart', 'n', ''),
(52, 1, 'it135', 'aas-fall-freshman-winterStart', 'n', ''),
(53, 1, 'it131', 'aas-fall-freshman-winterStart', 'n', ''),
(54, 1, 'it141', 'aas-fall-freshman-fallStart', 'n', ''),
(55, 1, 'it121', 'aas-winter-freshman-fallStart', 'n', ''),
(56, 1, 'it201', 'aas-winter-freshman-fallStart', 'n', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseid`);

--
-- Indexes for table `scheduled_courses`
--
ALTER TABLE `scheduled_courses`
  ADD PRIMARY KEY (`scid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `scheduled_courses`
--
ALTER TABLE `scheduled_courses`
  MODIFY `scid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=57;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
