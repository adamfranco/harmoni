-- /**
-- @package harmoni.osid_v2.coursemanagement
-- 
-- 
-- @copyright Copyright &copy; 2006, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
-- 
-- @version $Id: MySQL_CourseManagement.sql,v 1.4 2006/06/27 19:24:30 sporktim Exp $
-- */
-- --------------------------------------------------------

-- --------------------------------------------------------



-- --------------------------------------------------------

-- 
-- Table structure for table `cm_can`
-- 

CREATE TABLE `cm_can` (
  `id` varchar(170) NOT NULL default '',
  `number` varchar(170) default NULL,
  `credits` float default NULL,
  `equivalent` varchar(170) default NULL,
  `fk_cm_can_type` varchar(170) default NULL,
  `title` varchar(255) default NULL,
  `fk_cm_can_stat_type` varchar(170) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table holds all of the canonical course listings.';

-- --------------------------------------------------------

-- 
-- Table structure for table `cm_can_stat_type`
-- 

CREATE TABLE `cm_can_stat_type` (
  `id` int(170) unsigned NOT NULL auto_increment,
  `keyword` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `domain` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains various canonical course statuses' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `cm_can_type`
-- 

CREATE TABLE `cm_can_type` (
  `id` int(170) unsigned NOT NULL auto_increment,
  `keyword` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `domain` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains various types of canonical courses' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `cm_grade_type`
-- 

CREATE TABLE `cm_grade_type` (
  `id` int(170) unsigned NOT NULL auto_increment,
  `keyword` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `domain` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains various ways to grade a course' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `cm_offer`
-- 

CREATE TABLE `cm_offer` (
  `id` varchar(170) NOT NULL default '',
  `fk_cm_grade_type` varchar(170) default NULL,
  `fk_cm_term` varchar(170) default NULL,
  `fk_cm_offer_stat_type` varchar(255) default NULL,
  `fk_cm_offer_type` varchar(170) default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_offer_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains all of the course offerings';

-- --------------------------------------------------------

-- 
-- Table structure for table `cm_offer_stat_type`
-- 

CREATE TABLE `cm_offer_stat_type` (
  `id` int(170) unsigned NOT NULL auto_increment,
  `keyword` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `domain` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains various course offering statuses' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `cm_offer_type`
-- 

CREATE TABLE `cm_offer_type` (
  `id` int(170) unsigned NOT NULL auto_increment,
  `keyword` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `domain` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains various types of course offerings' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `cm_section`
-- 

CREATE TABLE `cm_section` (
  `id` varchar(170) NOT NULL default '',
  `fk_cm_offer` varchar(170) default NULL,
  `meeting_location` varchar(255) default NULL,
  `student_roster` text,
  `meeting_time` varchar(255) default NULL,
  `fk_cm_section_type` varchar(170) default NULL,
  `fk_cm_section_stat_type` varchar(170) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains course sections';

-- --------------------------------------------------------

-- 
-- Table structure for table `cm_section_stat_type`
-- 

CREATE TABLE `cm_section_stat_type` (
  `id` int(170) unsigned NOT NULL auto_increment,
  `keyword` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `domain` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains various course section statuses' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `cm_section_type`
-- 

CREATE TABLE `cm_section_type` (
  `id` int(170) unsigned NOT NULL auto_increment,
  `keyword` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `domain` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains various types of course sections' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `cm_term`
-- 

CREATE TABLE `cm_term` (
  `id` varchar(170) NOT NULL default '',
  `name` varchar(255) default NULL,
  `fk_cm_term_type` varchar(170) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table stores various terms';

-- --------------------------------------------------------

-- 
-- Table structure for table `cm_term_type`
-- 

CREATE TABLE `cm_term_type` (
  `id` int(170) unsigned NOT NULL auto_increment,
  `keyword` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `domain` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains various types of terms' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
