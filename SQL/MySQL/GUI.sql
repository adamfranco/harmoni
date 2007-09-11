-- /**
-- @package harmoni.osid_v2.gui
-- 
-- 
-- @copyright Copyright &copy; 2006, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
-- 
-- @version $Id: GUI.sql,v 1.1 2007/09/11 19:06:28 adamfranco Exp $
-- */
-- --------------------------------------------------------


-- 
-- Table structure for table `tm_style_collection`
-- 

CREATE TABLE `tm_style_collection` (
  `collection_id` varchar(75) NOT NULL default '0',
  `collection_display_name` varchar(255) NOT NULL default '',
  `collection_description` text,
  `collection_class_selector` varchar(255) NOT NULL default '',
  `collection_selector` varchar(255) NOT NULL default '',
  `collection_component` varchar(255) NOT NULL default 'BLANK',
  `collection_index` varchar(255) NOT NULL default '',
  `collection_class` varchar(255) NOT NULL default '',
  `FK_theme_id` varchar(255) NOT NULL default ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `tm_style_component`
-- 

CREATE TABLE `tm_style_component` (
  `component_id` varchar(75) NOT NULL default '0',
  `component_class_name` varchar(255) NOT NULL default '',
  `component_value` varchar(255) NOT NULL default '',
  `FK_property_id` varchar(75) NOT NULL default ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `tm_style_property`
-- 

CREATE TABLE `tm_style_property` (
  `property_id` varchar(75) NOT NULL default '0',
  `property_name` varchar(255) default NULL,
  `property_display_name` varchar(255) default '',
  `property_description` text,
  `FK_collection_id` varchar(75) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `tm_theme`
-- 

CREATE TABLE `tm_theme` (
  `theme_id` varchar(75) NOT NULL default '0',
  `theme_display_name` varchar(255) NOT NULL default '',
  `theme_description` text NOT NULL,
  `theme_template` tinyint(1) NOT NULL default '0',
  `theme_custom_lev` varchar(75) NOT NULL default '',
  `theme_owner_id` varchar(170) NOT NULL default '""',
  KEY `theme_owner_id` (`theme_owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
