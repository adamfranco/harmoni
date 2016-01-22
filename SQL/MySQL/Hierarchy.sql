-- /**
-- @package harmoni.osid_v2.hierarchy
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: Hierarchy.sql,v 1.2 2007/09/14 19:53:37 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `hierarchy`
-- 

CREATE TABLE `hierarchy` (
  `hierarchy_id` varchar(75) NOT NULL,
  `hierarchy_display_name` varchar(255) NOT NULL default '',
  `hierarchy_description` text NOT NULL,
  `hierarchy_multiparent` enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (`hierarchy_id`),
  KEY `hierarchy_display_name` (`hierarchy_display_name`),
  KEY `hierarchy_multiparent` (`hierarchy_multiparent`)
) 
CHARACTER SET utf8
ENGINE=InnoDB;

-- --------------------------------------------------------

-- 
-- Table structure for table `j_node_node`
-- 

CREATE TABLE j_node_node (
  fk_hierarchy varchar(75) NOT NULL,
  fk_parent varchar(75) NOT NULL,
  fk_child varchar(75) NOT NULL,
  PRIMARY KEY  (fk_parent,fk_child),
  KEY fk_parent (fk_parent),
  KEY fk_child (fk_child)
) 
CHARACTER SET utf8
ENGINE=InnoDB;

-- --------------------------------------------------------

-- 
-- Table structure for table `node`
-- 

CREATE TABLE node (
  node_id varchar(75) NOT NULL,
  node_display_name varchar(255) NOT NULL default '',
  node_description text NOT NULL,
  fk_hierarchy varchar(75) NOT NULL,
  fk_type int(10) unsigned NOT NULL default '0',
  az_node_changed timestamp NULL default NULL,
  PRIMARY KEY  (fk_hierarchy,node_id),
  KEY node_display_name (node_display_name),
  KEY fk_hierarchy (fk_hierarchy),
  KEY fk_type (fk_type),
  KEY az_node_changed (az_node_changed)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table structure for table `node_ancestry`
-- 

CREATE TABLE node_ancestry (
  fk_hierarchy varchar(75) NOT NULL,
  fk_node varchar(255) NOT NULL default '',
  fk_ancestor varchar(255) default NULL,
  `level` smallint(6) NOT NULL default '0',
  fk_ancestors_child varchar(255) default NULL,
  KEY fk_ancestor (fk_ancestor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
