-- /**
-- @package harmoni.osid_v2.agent
-- 
-- 
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
-- 
-- @version $Id: Agent.sql,v 1.2 2007/11/07 19:09:45 adamfranco Exp $
-- */
-- --------------------------------------------------------

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
-- Table structure for table agent_external_children
-- 
CREATE TABLE `agent_external_children` (
  `fk_parent` varchar(140) collate utf8_bin NOT NULL,
  `fk_child` varchar(140) collate utf8_bin NOT NULL,
  UNIQUE KEY `parent_child_unique` (`fk_parent`,`fk_child`),
  KEY `fk_parent` (`fk_parent`),
  KEY `fk_child` (`fk_child`)
) ENGINE=InnoDB COMMENT = 'This table allows addition of external-defined groups to hierarchy-based groups.';