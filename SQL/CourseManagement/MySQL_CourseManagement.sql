-- /**
-- @package harmoni.osid_v2.coursemanagement
-- 
-- 
-- @copyright Copyright &copy; 2006, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
-- 
-- @version $Id: MySQL_CourseManagement.sql,v 1.1 2006/06/23 14:31:05 sporktim Exp $
-- */
-- --------------------------------------------------------

-- --------------------------------------------------------

-- 
-- Table structure for table `cm_can_courses`
-- 

CREATE TABLE `cm_can_courses` (
  `title` varchar(255) default NULL,
  `id` varchar(170) NOT NULL default '',
  `description` text,
  `number` varchar(170) default NULL,
  `fk_cm_type` int(4) default NULL,
  `credits` float default NULL,
  `equivalent` varchar(170) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='This table holds all of the canonical course listings.';

-- --------------------------------------------------------

-- 
-- Table structure for table `cm_course_offer`
-- 

CREATE TABLE `cm_course_offer` (
  `description` text,
  `id` varchar(170) NOT NULL default '',
  `fk_cm_off_type` int(4) default NULL,
  `fk_cm_grade_type` int(4) default NULL,
  `fk_cm_term` varchar(170) default NULL,
  `fk_cm_stat_type` varchar(4) default NULL,
  `fk_cm_can_course` varchar(170) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='This table contains all of the course offerings';

-- 
-- Table structure for table `cm_course_type`
-- 

CREATE TABLE `cm_course_type` (
  `domain` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `keyword` varchar(255) NOT NULL default '',
  `description` text,
  PRIMARY KEY  (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='This table contains types of canonical courses';

-- 
-- Table structure for table `cm_grade_type`
-- 

CREATE TABLE `cm_grade_type` (
  `domain` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `keyword` varchar(255) NOT NULL default '',
  `description` text,
  PRIMARY KEY  (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='This table contains grading types';

-- 
-- Dumping data for table `cm_grade_type`
-- 

