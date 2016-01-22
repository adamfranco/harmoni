-- /**
-- @package harmoni.osid_v2.authorization
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: AuthZ.sql,v 1.1 2007/09/11 19:06:27 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `az_authorization`
-- 

CREATE TABLE az_authorization (
  authorization_id varchar(75) NOT NULL default '0',
  fk_agent varchar(150) NOT NULL default '0',
  fk_function varchar(75) NOT NULL default '0',
  fk_qualifier varchar(75) NOT NULL default '0',
  authorization_effective_date datetime default NULL,
  authorization_expiration_date datetime default NULL,
  PRIMARY KEY  (authorization_id),
  KEY fk_qualifier (fk_qualifier),
  KEY fk_agent (fk_agent)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `az_function`
-- 

CREATE TABLE az_function (
  function_id varchar(75) NOT NULL default '0',
  function_reference_name varchar(255) NOT NULL default '',
  function_description text NOT NULL,
  fk_qualifier_hierarchy varchar(75) NOT NULL default '0',
  fk_type int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (function_id),
  KEY function_display_name (function_reference_name),
  KEY fk_qualifier_hierarchy_id (fk_qualifier_hierarchy),
  KEY fk_type (fk_type)
) 
CHARACTER SET utf8
ENGINE=InnoDB;