-- /**
-- @package harmoni.osid_v2.grading
-- 
-- 
-- @copyright Copyright &copy; 2006, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
-- 
-- @version $Id: MySQL_Grading.sql,v 1.2 2006/07/18 21:37:25 sporktim Exp $
-- */
-- --------------------------------------------------------


-- Table structure for table `gr_gradable`
-- 

CREATE TABLE `gr_gradable` (
  `id` varchar(170) NOT NULL default '',
  `fk_gr_scoring_type` varchar(170) default NULL,
  `fk_gr_grade_type` varchar(170) default NULL,
  `fk_gr_gradescale_type` varchar(170) default NULL,
  `description` text,
  `name` varchar(255) default NULL,
  `modified_date` bigint(20) default NULL,
  `fk_modified_by_agent` varchar(170) default NULL,
  `fk_reference_id` varchar(170) default NULL,
  `fk_cm_section` varchar(170) NOT NULL default '',
  `weight` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `fk_reference_id` (`fk_reference_id`,`fk_cm_section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains all of the gradable objects';

-- --------------------------------------------------------

-- 
-- Table structure for table `gr_grade_type`
-- 

CREATE TABLE `gr_grade_type` (
  `id` int(170) unsigned NOT NULL auto_increment,
  `keyword` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `domain` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains various types of grades' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `gr_gradescale_type`
-- 

CREATE TABLE `gr_gradescale_type` (
  `id` int(170) unsigned NOT NULL auto_increment,
  `keyword` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `domain` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains various types of grade scales' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `gr_record`
-- 

CREATE TABLE `gr_record` (
  `id` varchar(170) NOT NULL default '',
  `value` varchar(255) default NULL,
  `fk_gr_gradable` varchar(170) default NULL,
  `fk_agent_id` varchar(170) default NULL,
  `fk_modified_by_agent` varchar(170) default NULL,
  `modified_date` bigint(20) default NULL,
  `fk_gr_record_type` varchar(170) default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_gr_gradable` (`fk_gr_gradable`),
  KEY `fk_agent_id` (`fk_agent_id`),
  KEY `fk_gr_record_type` (`fk_gr_record_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='This table contains all of the GradeRecords';

-- --------------------------------------------------------

-- 
-- Table structure for table `gr_record_type`
-- 

CREATE TABLE `gr_record_type` (
  `id` int(170) unsigned NOT NULL auto_increment,
  `keyword` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `domain` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains various types of grade records' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `gr_scoring_type`
-- 

CREATE TABLE `gr_scoring_type` (
  `id` int(170) unsigned NOT NULL auto_increment,
  `keyword` varchar(255) default NULL,
  `authority` varchar(255) default NULL,
  `domain` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains various types of ScoringDefinitions' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
