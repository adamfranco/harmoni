-- /**
-- @package harmoni.osid_v2.scheduling
-- 
-- 
-- @copyright Copyright &copy; 2006, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
-- 
-- @version $Id: MySQL_Scheduling.sql,v 1.2 2006/07/06 18:33:52 sporktim Exp $
-- */
-- --------------------------------------------------------


-- 
-- Table structure for table `sc_item`
-- 

CREATE TABLE `sc_item` (
  `id` varchar(170) character set latin1 collate latin1_general_ci NOT NULL default '',
  `name` varchar(255) character set latin1 collate latin1_general_ci default NULL,
  `description` text character set latin1 collate latin1_general_ci,
  `start` bigint(20) default NULL,
  `end` bigint(20) default NULL,
  `fk_sc_item_stat_type` varchar(170) character set latin1 collate latin1_general_ci default NULL,
  `master_id` varchar(170) character set latin1 collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`),
  KEY `start` (`start`,`end`,`fk_sc_item_stat_type`,`master_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table holds all of the ScheduleItems.';


-- 
-- Table structure for table `sc_commit`
-- 

CREATE TABLE `sc_commit` (
  `id` int(170) NOT NULL auto_increment,
  `fk_agent_id` varchar(170) default NULL,
  `fk_sc_commit_stat_type` varchar(170) default NULL,
  `fk_sc_item` varchar(170) default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_sc_commit_stat_type` (`fk_sc_commit_stat_type`,`fk_sc_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table holds the agents that are commited to various Sch' AUTO_INCREMENT=1 ;
