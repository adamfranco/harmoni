-- /**
-- @package harmoni.osid_v2.authorization
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: MySQL_AuthZ.sql,v 1.4 2005/04/20 21:07:42 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `az_authorization`
-- 

CREATE TABLE az_authorization (
  authorization_id varchar(75) NOT NULL default '0',
  fk_agent varchar(75) NOT NULL default '0',
  fk_function varchar(75) NOT NULL default '0',
  fk_qualifier varchar(75) NOT NULL default '0',
  authorization_effective_date datetime default NULL,
  authorization_expiration_date datetime default NULL,
  PRIMARY KEY  (authorization_id),
  UNIQUE KEY uniq (fk_agent,fk_function,fk_qualifier),
  KEY fk_agent (fk_agent),
  KEY fk_function (fk_function),
  KEY fk_qualifier (fk_qualifier),
  KEY authorization_effective_date (authorization_effective_date),
  KEY authorization_expiration_date (authorization_expiration_date)
) TYPE=MyISAM;

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
) TYPE=MyISAM;