-- /**
-- @package harmoni.osid_v2.repository
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: MySQL_DigitalRepository.sql,v 1.13 2006/05/04 18:58:58 adamfranco Exp $
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
) 
CHARACTER SET utf8
TYPE=InnoDB;

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_asset_record`
-- 

CREATE TABLE dr_asset_record (
  FK_asset varchar(75) NOT NULL default '0',
  FK_record varchar(75) NOT NULL default '0',
  structure_id varchar(75) NOT NULL default '',
  PRIMARY KEY  (structure_id,FK_asset,FK_record)
) 
CHARACTER SET utf8
TYPE=InnoDB;

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_file`
-- 

CREATE TABLE dr_file (
  id varchar(75) NOT NULL default '0',
  filename varchar(255) NOT NULL default '',
  FK_mime_type int(10) unsigned default NULL,
  size int(11) NOT NULL default '0',
  width int(11) default NULL,
  height int(11) default NULL,
  mod_time timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_file_data`
-- 

CREATE TABLE dr_file_data (
  FK_file varchar(75) NOT NULL default '0',
  data longblob NOT NULL,
  PRIMARY KEY  (FK_file)
) 
CHARACTER SET utf8
TYPE=InnoDB;

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_mime_type`
-- 

CREATE TABLE dr_mime_type (
  id int(10) unsigned NOT NULL auto_increment,
  type varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) 
CHARACTER SET utf8
TYPE=InnoDB;

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_repository_type`
-- 

CREATE TABLE dr_repository_type (
  repository_id varchar(75) NOT NULL default '0',
  fk_dr_type int(11) NOT NULL default '0',
  PRIMARY KEY  (repository_id),
  KEY fk_dr_type (fk_dr_type)
) 
CHARACTER SET utf8
TYPE=InnoDB;

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_thumbnail`
-- 

CREATE TABLE dr_thumbnail (
  FK_file varchar(75) NOT NULL default '0',
  FK_mime_type int(10) unsigned default NULL,
  data mediumblob NOT NULL,
  width int(11) default NULL,
  height int(11) default NULL,
  PRIMARY KEY  (FK_file)
) 
CHARACTER SET utf8
TYPE=InnoDB;

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
) 
CHARACTER SET utf8
TYPE=InnoDB;


-- --------------------------------------------------------

-- 
-- Table structure for table `dr_resized_cache`
-- 

CREATE TABLE dr_resized_cache (
  FK_file varchar(75) NOT NULL default '0',
  size int(11) NOT NULL default '0',
  websafe tinyint(1) NOT NULL default '0',
  cache_time timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  FK_mime_type int(10) unsigned default NULL,
  `data` longblob NOT NULL,
  PRIMARY KEY  (FK_file,size,websafe)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table is use by polyphony.modules.repository';

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_authoritative_values`
-- 

CREATE TABLE dr_authoritative_values (
  fk_partstructure varchar(100) NOT NULL default '',
  `value` varchar(240) NOT NULL default '',
  PRIMARY KEY  (fk_partstructure,`value`),
  KEY fk_partstructure (fk_partstructure)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table is used by the part structure to maintain authori';

-- --------------------------------------------------------

-- 
-- Table structure for table `dr_authority_options`
-- 

CREATE TABLE dr_authority_options (
  fk_partstructure varchar(100) NOT NULL default '',
  user_addition_allowed tinyint(1) NOT NULL default '0',
  KEY fk_partstructure (fk_partstructure)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table is used by the part structure to maintain authori';
