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
        
