-- /**
-- @package harmoni.osid_v2.agent
-- 
-- 
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
-- 
-- @version $Id: Agent.sql,v 1.1 2007/09/11 19:06:27 adamfranco Exp $
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


