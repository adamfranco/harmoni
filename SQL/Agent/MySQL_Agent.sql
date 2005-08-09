-- /**
-- @package harmoni.osid_v2.agent
-- 
-- 
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
-- 
-- @version $Id: MySQL_Agent.sql,v 1.7 2005/08/09 15:06:04 adamfranco Exp $
-- */
-- --------------------------------------------------------


-- 
-- Table structure for table `agent`
-- 

CREATE TABLE agent (
  agent_id varchar(75) NOT NULL default '0',
  agent_display_name varchar(255) NOT NULL default '',
  fk_type int(10) NOT NULL default '0',
  PRIMARY KEY  (agent_id),
  KEY agent_display_name (agent_display_name),
  KEY fk_type (fk_type)
) 
CHARACTER SET utf8
TYPE=InnoDB;

-- --------------------------------------------------------
-- 
-- Table structure for table `agent_properties`
-- 

CREATE TABLE `agent_properties` (
  `property_id` int(11) NOT NULL auto_increment,
  `fk_object_id` varchar(255) NOT NULL default '0',
  `fk_type_id` varchar(255) NOT NULL default '',
  `property_key` varchar(255) NOT NULL default '',
  `property_value` text NOT NULL,
  PRIMARY KEY  (`property_id`),
  KEY `fk_object_id` (`fk_object_id`),
  KEY `fk_type_id` (`fk_type_id`)
) 
CHARACTER SET utf8
TYPE=InnoDB;


-- --------------------------------------------------------

-- 
-- Table structure for table `groups`
-- 

CREATE TABLE groups (
  groups_id varchar(75) NOT NULL default '0',
  groups_display_name varchar(255) NOT NULL default '',
  groups_description text NOT NULL,
  fk_type int(10) NOT NULL default '0',
  PRIMARY KEY  (groups_id),
  KEY agent_display_name (groups_display_name),
  KEY fk_type (fk_type)
) 
CHARACTER SET utf8
TYPE=InnoDB;

-- --------------------------------------------------------

-- 
-- Table structure for table `j_groups_agent`
-- 

CREATE TABLE j_groups_agent (
  fk_groups varchar(75) NOT NULL default '0',
  fk_agent varchar(75) NOT NULL default '0',
  PRIMARY KEY  (fk_groups,fk_agent)
) 
CHARACTER SET utf8
TYPE=InnoDB;

-- --------------------------------------------------------

-- 
-- Table structure for table `j_groups_groups`
-- 

CREATE TABLE j_groups_groups (
  fk_parent varchar(75) NOT NULL default '0',
  fk_child varchar(75) NOT NULL default '0',
  PRIMARY KEY  (fk_parent,fk_child)
) 
CHARACTER SET utf8
TYPE=InnoDB;
        