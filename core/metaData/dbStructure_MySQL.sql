# phpMyAdmin SQL Dump
# version 2.5.3-rc3
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Nov 23, 2003 at 07:07 PM
# Server version: 3.23.49
# PHP Version: 4.3.3
# 
# Database : `harmoni`
# 

# --------------------------------------------------------

#
# Table structure for table `data_boolean`
#
# Creation: Nov 17, 2003 at 10:10 PM
# Last update: Nov 17, 2003 at 10:10 PM
#

CREATE TABLE data_boolean (
  data_boolean_id bigint(20) unsigned NOT NULL default '0',
  data_boolean_data tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (data_boolean_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `data_integer`
#
# Creation: Nov 11, 2003 at 04:42 PM
# Last update: Nov 11, 2003 at 04:42 PM
#

CREATE TABLE data_integer (
  data_integer_id bigint(20) unsigned NOT NULL default '0',
  data_integer_data bigint(20) NOT NULL default '0',
  PRIMARY KEY  (data_integer_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `data_string`
#
# Creation: Nov 11, 2003 at 04:42 PM
# Last update: Nov 11, 2003 at 04:42 PM
#

CREATE TABLE data_string (
  data_string_id bigint(20) unsigned NOT NULL default '0',
  data_string_data varchar(255) NOT NULL default '',
  PRIMARY KEY  (data_string_id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `dataset`
#
# Creation: Nov 17, 2003 at 10:10 PM
# Last update: Nov 17, 2003 at 10:10 PM
# Last check: Nov 17, 2003 at 10:10 PM
#

CREATE TABLE dataset (
  dataset_id bigint(20) unsigned NOT NULL default '0',
  fk_datasettype bigint(20) unsigned NOT NULL default '0',
  dataset_created datetime NOT NULL default '0000-00-00 00:00:00',
  dataset_active tinyint(1) unsigned NOT NULL default '0',
  dataset_ver_control tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (dataset_id),
  KEY fk_datasettype (fk_datasettype)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `dataset_tag`
#
# Creation: Nov 13, 2003 at 05:01 PM
# Last update: Nov 13, 2003 at 05:01 PM
# Last check: Nov 13, 2003 at 05:01 PM
#

CREATE TABLE dataset_tag (
  dataset_tag_id bigint(20) unsigned NOT NULL default '0',
  fk_dataset bigint(20) unsigned NOT NULL default '0',
  dataset_tag_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (dataset_tag_id),
  KEY fk_dataset (fk_dataset),
  KEY dataset_tag_date (dataset_tag_date)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `dataset_tag_map`
#
# Creation: Nov 13, 2003 at 05:03 PM
# Last update: Nov 13, 2003 at 05:03 PM
# Last check: Nov 13, 2003 at 05:03 PM
#

CREATE TABLE dataset_tag_map (
  fk_dataset_tag bigint(20) unsigned NOT NULL default '0',
  fk_datasetfield bigint(20) unsigned NOT NULL default '0',
  KEY fk_dataset_tag (fk_dataset_tag),
  KEY fk_datasetfield (fk_datasetfield)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `datasetfield`
#
# Creation: Nov 17, 2003 at 10:11 PM
# Last update: Nov 17, 2003 at 10:11 PM
# Last check: Nov 17, 2003 at 10:11 PM
#

CREATE TABLE datasetfield (
  datasetfield_id bigint(20) unsigned NOT NULL default '0',
  fk_dataset bigint(20) unsigned NOT NULL default '0',
  fk_datasettypedef bigint(20) unsigned NOT NULL default '0',
  datasetfield_index bigint(20) unsigned NOT NULL default '0',
  fk_data bigint(20) unsigned NOT NULL default '0',
  datasetfield_active tinyint(1) unsigned NOT NULL default '0',
  datasetfield_created datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (datasetfield_id),
  KEY fk_dataset (fk_dataset),
  KEY fk_datasettypedef (fk_datasettypedef),
  KEY fk_data (fk_data),
  KEY datasetfield_created (datasetfield_created),
  KEY datasetfield_index (datasetfield_index)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `datasettype`
#
# Creation: Nov 14, 2003 at 03:20 PM
# Last update: Nov 15, 2003 at 06:42 PM
#

CREATE TABLE datasettype (
  datasettype_id bigint(20) unsigned NOT NULL default '0',
  datasettype_domain varchar(255) NOT NULL default '',
  datasettype_authority varchar(255) NOT NULL default '',
  datasettype_keyword varchar(255) NOT NULL default '',
  datasettype_description tinytext NOT NULL,
  PRIMARY KEY  (datasettype_id),
  UNIQUE KEY datasettype_unique_key (datasettype_domain(100),datasettype_authority(100),datasettype_keyword(100))
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `datasettypedef`
#
# Creation: Nov 17, 2003 at 10:10 PM
# Last update: Nov 17, 2003 at 10:10 PM
# Last check: Nov 17, 2003 at 10:10 PM
#

CREATE TABLE datasettypedef (
  datasettypedef_id bigint(20) unsigned NOT NULL default '0',
  fk_datasettype bigint(20) unsigned NOT NULL default '0',
  datasettypedef_label varchar(255) NOT NULL default '',
  datasettypedef_mult tinyint(1) unsigned NOT NULL default '0',
  datasettypedef_fieldtype varchar(255) NOT NULL default '',
  datasettypedef_active tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (datasettypedef_id),
  KEY fk_datasettype (fk_datasettype),
  KEY datasettypedef_label (datasettypedef_label)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `harmoni_id`
#
# Creation: Nov 11, 2003 at 08:03 PM
# Last update: Nov 15, 2003 at 06:42 PM
#

CREATE TABLE harmoni_id (
  harmoni_id_number bigint(20) unsigned NOT NULL default '0',
  harmoni_id_domain varchar(255) NOT NULL default '',
  harmoni_id_authority varchar(255) NOT NULL default '',
  harmoni_id_keyword varchar(255) NOT NULL default '',
  PRIMARY KEY  (harmoni_id_number)
) TYPE=MyISAM;
