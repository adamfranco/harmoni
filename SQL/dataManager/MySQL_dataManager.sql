# CocoaMySQL dump
# Version 0.5
# http://cocoamysql.sourceforge.net
#
# Host: localhost (MySQL 4.0.15)
# Database: harmoni
# Generation Time: 2004-01-16 20:09:19 -0500
# ************************************************************

# Dump of table data_blob
# ------------------------------------------------------------

CREATE TABLE `data_blob` (
  `data_blob_id` bigint(20) unsigned NOT NULL default '0',
  `data_blob_data` blob NOT NULL,
  PRIMARY KEY  (`data_blob_id`)
) TYPE=MyISAM;



# Dump of table data_boolean
# ------------------------------------------------------------

CREATE TABLE `data_boolean` (
  `data_boolean_id` bigint(20) unsigned NOT NULL default '0',
  `data_boolean_data` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`data_boolean_id`)
) TYPE=MyISAM;



# Dump of table data_date
# ------------------------------------------------------------

CREATE TABLE `data_date` (
  `data_date_id` bigint(20) unsigned NOT NULL default '0',
  `data_date_data` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`data_date_id`)
) TYPE=MyISAM;



# Dump of table data_float
# ------------------------------------------------------------

CREATE TABLE `data_float` (
  `data_float_id` bigint(20) unsigned NOT NULL default '0',
  `data_float_data` double NOT NULL default '0',
  PRIMARY KEY  (`data_float_id`)
) TYPE=MyISAM;



# Dump of table data_fuzzydate
# ------------------------------------------------------------

CREATE TABLE `data_fuzzydate` (
  `data_fuzzydate_id` bigint(20) unsigned NOT NULL default '0',
  `data_fuzzydate_mean` bigint(20) unsigned NOT NULL default '0',
  `data_fuzzydate_range` bigint(20) unsigned NOT NULL default '0',
  `data_fuzzydate_string` varchar(255) default NULL,
  PRIMARY KEY  (`data_fuzzydate_id`)
) TYPE=MyISAM;



# Dump of table data_integer
# ------------------------------------------------------------

CREATE TABLE `data_integer` (
  `data_integer_id` bigint(20) unsigned NOT NULL default '0',
  `data_integer_data` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`data_integer_id`)
) TYPE=MyISAM;



# Dump of table data_shortstring
# ------------------------------------------------------------

CREATE TABLE `data_shortstring` (
  `data_shortstring_id` bigint(20) unsigned NOT NULL default '0',
  `data_shortstring_data` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`data_shortstring_id`)
) TYPE=MyISAM;

# Dump of table data_okitype
# ------------------------------------------------------------

CREATE TABLE `data_okitype` (
  `data_okitype_id` bigint(20) unsigned NOT NULL default '0',
  `data_okitype_domain` varchar(255) NOT NULL default '',
  `data_okitype_authority` varchar(255) NOT NULL default '',
  `data_okitype_keyword` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`data_okitype_id`)
) TYPE=MyISAM;

# Dump of table data_string
# ------------------------------------------------------------

CREATE TABLE `data_string` (
  `data_string_id` bigint(20) unsigned NOT NULL default '0',
  `data_string_data` text NOT NULL,
  PRIMARY KEY  (`data_string_id`)
) TYPE=MyISAM;



# Dump of table dataset
# ------------------------------------------------------------

CREATE TABLE `dataset` (
  `dataset_id` bigint(20) unsigned NOT NULL default '0',
  `fk_datasettype` bigint(20) unsigned NOT NULL default '0',
  `dataset_created` datetime NOT NULL default '0000-00-00 00:00:00',
  `dataset_active` tinyint(1) unsigned NOT NULL default '0',
  `dataset_ver_control` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`dataset_id`),
  KEY `fk_datasettype` (`fk_datasettype`)
) TYPE=MyISAM;



# Dump of table dataset_group
# ------------------------------------------------------------

CREATE TABLE `dataset_group` (
  `id` bigint(20) unsigned NOT NULL default '0',
  `fk_dataset` bigint(20) unsigned NOT NULL default '0',
  KEY `id` (`id`),
  KEY `fk_dataset` (`fk_dataset`)
) TYPE=MyISAM;



# Dump of table dataset_tag
# ------------------------------------------------------------

CREATE TABLE `dataset_tag` (
  `dataset_tag_id` bigint(20) unsigned NOT NULL default '0',
  `fk_dataset` bigint(20) unsigned NOT NULL default '0',
  `dataset_tag_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`dataset_tag_id`),
  KEY `fk_dataset` (`fk_dataset`),
  KEY `dataset_tag_date` (`dataset_tag_date`)
) TYPE=MyISAM;



# Dump of table dataset_tag_map
# ------------------------------------------------------------

CREATE TABLE `dataset_tag_map` (
  `fk_dataset_tag` bigint(20) unsigned NOT NULL default '0',
  `fk_datasetfield` bigint(20) unsigned NOT NULL default '0',
  KEY `fk_dataset_tag` (`fk_dataset_tag`),
  KEY `fk_datasetfield` (`fk_datasetfield`)
) TYPE=MyISAM;



# Dump of table datasetfield
# ------------------------------------------------------------

CREATE TABLE `datasetfield` (
  `datasetfield_id` bigint(20) unsigned NOT NULL default '0',
  `fk_dataset` bigint(20) unsigned NOT NULL default '0',
  `fk_datasettypedef` bigint(20) unsigned NOT NULL default '0',
  `datasetfield_index` bigint(20) unsigned NOT NULL default '0',
  `fk_data` bigint(20) unsigned NOT NULL default '0',
  `datasetfield_active` tinyint(1) unsigned NOT NULL default '0',
  `datasetfield_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`datasetfield_id`),
  KEY `fk_dataset` (`fk_dataset`),
  KEY `fk_datasettypedef` (`fk_datasettypedef`),
  KEY `fk_data` (`fk_data`),
  KEY `datasetfield_active` (`datasetfield_active`)
) TYPE=MyISAM;



# Dump of table datasettype
# ------------------------------------------------------------

CREATE TABLE `datasettype` (
  `datasettype_id` bigint(20) unsigned NOT NULL default '0',
  `datasettype_domain` varchar(255) NOT NULL default '',
  `datasettype_authority` varchar(255) NOT NULL default '',
  `datasettype_keyword` varchar(255) NOT NULL default '',
  `datasettype_description` tinytext NOT NULL,
  PRIMARY KEY  (`datasettype_id`),
  UNIQUE KEY `datasettype_unique_key` (`datasettype_domain`(100),`datasettype_authority`(100),`datasettype_keyword`(100))
) TYPE=MyISAM;



# Dump of table datasettypedef
# ------------------------------------------------------------

CREATE TABLE `datasettypedef` (
  `datasettypedef_id` bigint(20) unsigned NOT NULL default '0',
  `fk_datasettype` bigint(20) unsigned NOT NULL default '0',
  `datasettypedef_label` varchar(255) NOT NULL default '',
  `datasettypedef_mult` tinyint(1) unsigned NOT NULL default '0',
  `datasettypedef_fieldtype` varchar(255) NOT NULL default '',
  `datasettypedef_active` tinyint(1) unsigned NOT NULL default '0',
  `datasettypedef_required` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`datasettypedef_id`),
  KEY `fk_datasettype` (`fk_datasettype`),
  KEY `datasettypedef_label` (`datasettypedef_label`)
) TYPE=MyISAM;
