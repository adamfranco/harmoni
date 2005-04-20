-- /**
-- @package harmoni.osid_v2.hierarchy
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: MySQL_hierarchy.sql,v 1.6 2005/04/20 21:07:43 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `hierarchy`
-- 

CREATE TABLE hierarchy (
  hierarchy_id varchar(75) NOT NULL default '0',
  hierarchy_display_name varchar(255) NOT NULL default '',
  hierarchy_description text NOT NULL,
  hierarchy_multiparent enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (hierarchy_id),
  KEY hierarchy_display_name (hierarchy_display_name),
  KEY hierarchy_multiparent (hierarchy_multiparent)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `j_node_node`
-- 

CREATE TABLE j_node_node (
  fk_parent varchar(75) NOT NULL default '0',
  fk_child varchar(75) NOT NULL default '0',
  PRIMARY KEY  (fk_parent,fk_child),
  KEY fk_parent (fk_parent),
  KEY fk_child (fk_child)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `node`
-- 

CREATE TABLE node (
  node_id varchar(75) NOT NULL default '0',
  node_display_name varchar(255) NOT NULL default '',
  node_description text NOT NULL,
  fk_hierarchy varchar(75) NOT NULL default '0',
  fk_type int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (fk_hierarchy,node_id),
  KEY node_display_name (node_display_name),
  KEY fk_hierarchy (fk_hierarchy),
  KEY fk_type (fk_type)
) TYPE=MyISAM;
        