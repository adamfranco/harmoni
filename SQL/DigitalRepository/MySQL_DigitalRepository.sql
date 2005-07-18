-- /**
-- @package harmoni.osid_v2.repository
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: MySQL_DigitalRepository.sql,v 1.7 2005/07/18 14:45:25 gabeschine Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `dr_asset_info`
-- 

CREATE TABLE dr_asset_info (
  asset_id varchar(75) NOT NULL default '0',
  effective_date datetime default '0000-00-00 00:00:00',
  expiration_date datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (asset_id)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_asset_record`
-- 

CREATE TABLE dr_asset_record (
  FK_asset varchar(75) NOT NULL default '0',
  FK_record varchar(75) NOT NULL default '0',
  structure_id varchar(75) NOT NULL default '',
  PRIMARY KEY  (structure_id,FK_asset,FK_record)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_file`
-- 

CREATE TABLE dr_file (
  id varchar(75) NOT NULL default '0',
  filename varchar(255) NOT NULL default '',
  FK_mime_type int(10) unsigned default NULL,
  size int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_file_data`
-- 

CREATE TABLE dr_file_data (
  FK_file varchar(75) NOT NULL default '0',
  data longblob NOT NULL,
  PRIMARY KEY  (FK_file)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_mime_type`
-- 

CREATE TABLE dr_mime_type (
  id int(10) unsigned NOT NULL auto_increment,
  type varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_repository_type`
-- 

CREATE TABLE dr_repository_type (
  repository_id varchar(75) NOT NULL default '0',
  fk_dr_type int(11) NOT NULL default '0',
  PRIMARY KEY  (repository_id),
  KEY fk_dr_type (fk_dr_type)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_thumbnail`
-- 

CREATE TABLE dr_thumbnail (
  FK_file varchar(75) NOT NULL default '0',
  FK_mime_type int(10) unsigned default NULL,
  data mediumblob NOT NULL,
  PRIMARY KEY  (FK_file)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_type`
-- 

CREATE TABLE dr_type (
  type_id int(11) NOT NULL auto_increment,
  type_domain varchar(100) NOT NULL default '',
  type_authority varchar(100) NOT NULL default '',
  type_keyword varchar(100) NOT NULL default '',
  type_description text NOT NULL,
  PRIMARY KEY  (type_id),
  UNIQUE KEY uniq (type_domain,type_authority,type_keyword)
) TYPE=MyISAM;