-- /**
-- @package harmoni.datamanager
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: MySQL_dataManager.sql,v 1.11 2005/04/20 19:39:50 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `dm_blob`
-- 

CREATE TABLE dm_blob (
  id bigint(20) unsigned NOT NULL default '0',
  data blob NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_boolean`
-- 

CREATE TABLE dm_boolean (
  id bigint(20) unsigned NOT NULL default '0',
  data tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_float`
-- 

CREATE TABLE dm_float (
  id bigint(20) unsigned NOT NULL default '0',
  data double NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_fuzzydate`
-- 

CREATE TABLE dm_fuzzydate (
  id bigint(20) unsigned NOT NULL default '0',
  mean bigint(20) unsigned NOT NULL default '0',
  range bigint(20) unsigned NOT NULL default '0',
  string varchar(255) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_integer`
-- 

CREATE TABLE dm_integer (
  id bigint(20) unsigned NOT NULL default '0',
  data bigint(20) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_okitype`
-- 

CREATE TABLE dm_okitype (
  id bigint(20) unsigned NOT NULL default '0',
  domain varchar(255) NOT NULL default '',
  authority varchar(255) NOT NULL default '',
  keyword varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_record`
-- 

CREATE TABLE dm_record (
  id varchar(255) NOT NULL default '0',
  fk_schema varchar(255) NOT NULL default '0',
  created datetime NOT NULL default '0000-00-00 00:00:00',
  active tinyint(1) unsigned NOT NULL default '0',
  ver_control tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY fk_schema (fk_schema)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_record_field`
-- 

CREATE TABLE dm_record_field (
  id bigint(20) unsigned NOT NULL default '0',
  fk_record varchar(255) NOT NULL default '0',
  fk_schema_field bigint(20) unsigned NOT NULL default '0',
  value_index bigint(20) unsigned NOT NULL default '0',
  fk_data bigint(20) unsigned NOT NULL default '0',
  active tinyint(1) unsigned NOT NULL default '0',
  modified datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (id),
  KEY fk_record (fk_record),
  KEY fk_schema_field (fk_schema_field),
  KEY fk_data (fk_data),
  KEY active (active)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_record_set`
-- 

CREATE TABLE dm_record_set (
  id varchar(255) NOT NULL default '0',
  fk_record varchar(255) NOT NULL default '0',
  PRIMARY KEY  (fk_record(250),id(250)),
  KEY id (id),
  KEY fk_record (fk_record)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_schema`
-- 

CREATE TABLE dm_schema (
  id varchar(255) NOT NULL default '0',
  domain varchar(255) NOT NULL default '',
  authority varchar(255) NOT NULL default '',
  keyword varchar(255) NOT NULL default '',
  description tinytext NOT NULL,
  revision int(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY unique_key (domain(100),authority(100),keyword(100))
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_schema_field`
-- 

CREATE TABLE dm_schema_field (
  id bigint(20) unsigned NOT NULL default '0',
  fk_schema varchar(255) NOT NULL default '0',
  label varchar(255) NOT NULL default '',
  mult tinyint(1) unsigned NOT NULL default '0',
  fieldtype varchar(255) NOT NULL default '',
  active tinyint(1) unsigned NOT NULL default '0',
  required tinyint(1) unsigned NOT NULL default '0',
  description tinytext NOT NULL,
  PRIMARY KEY  (id),
  KEY fk_schema (fk_schema),
  KEY label (label)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_shortstring`
-- 

CREATE TABLE dm_shortstring (
  id bigint(20) unsigned NOT NULL default '0',
  data varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_string`
-- 

CREATE TABLE dm_string (
  id bigint(20) unsigned NOT NULL default '0',
  data text NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_tag`
-- 

CREATE TABLE dm_tag (
  id bigint(20) unsigned NOT NULL default '0',
  fk_record varchar(255) NOT NULL default '0',
  date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (id),
  KEY fk_record (fk_record),
  KEY date (date)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_tag_map`
-- 

CREATE TABLE dm_tag_map (
  fk_tag bigint(20) unsigned NOT NULL default '0',
  fk_record_field bigint(20) unsigned NOT NULL default '0',
  KEY fk_tag (fk_tag),
  KEY fk_record_field (fk_record_field)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_time`
-- 

CREATE TABLE dm_time (
  id bigint(20) unsigned NOT NULL default '0',
  data bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
