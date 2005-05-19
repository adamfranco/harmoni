-- /**
-- shared_property and shared_properties no longer have any true use, they are 
-- in here for backward compatibility but should ultimately be removed--BG 5/19/2005

-- @package harmoni.osid_v2.shared
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: MySQL_shared.sql,v 1.9 2005/05/19 17:25:48 thebravecowboy Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `shared_properties`
-- 

CREATE TABLE shared_properties (
  id int(10) unsigned NOT NULL auto_increment,
  fk_type int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `shared_property`
-- 

CREATE TABLE shared_property (
  fk_properties int(10) unsigned NOT NULL auto_increment,
  property_key varchar(255) NOT NULL default '',
  property_value text NOT NULL,
  PRIMARY KEY  (fk_properties,property_key)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `type`
-- 

CREATE TABLE type (
  type_id int(10) NOT NULL auto_increment,
  type_domain varchar(255) NOT NULL default '',
  type_authority varchar(255) NOT NULL default '',
  type_keyword varchar(255) NOT NULL default '',
  type_description text,
  PRIMARY KEY  (type_id),
  KEY domain (type_domain),
  KEY authority (type_authority),
  KEY keyword (type_keyword)
) TYPE=MyISAM;
        