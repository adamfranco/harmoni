# phpMyAdmin MySQL-Dump
# version 2.3.3pl1
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jan 14, 2004 at 04:58 PM
# Server version: 3.23.56
# PHP Version: 4.3.2
# Database : `hierarchyManager`
# --------------------------------------------------------

#
# Table structure for table `hierarchy`
#

CREATE TABLE hierarchy (
  id int(10) unsigned NOT NULL default '0',
  display_name varchar(255) default NULL,
  description text,
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='Used by the OKI Hierarchy service.';
# --------------------------------------------------------

#
# Table structure for table `hierarchy_node`
#

CREATE TABLE hierarchy_node (
  id int(10) unsigned NOT NULL default '0',
  fk_hierarchy int(10) unsigned NOT NULL default '0',
  fk_parent int(10) unsigned NOT NULL default '0',
  display_name varchar(255) NOT NULL default '',
  description text NOT NULL,
  fk_nodetype int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id (id),
  KEY fk_hierarchy (fk_hierarchy),
  KEY fk_parent (fk_parent)
) TYPE=MyISAM COMMENT='Used by the OKI Hierarchy service.';
# --------------------------------------------------------

#
# Table structure for table `hierarchy_nodetype`
#

CREATE TABLE hierarchy_nodetype (
  id int(10) unsigned NOT NULL auto_increment,
  fk_hierarchy int(10) unsigned NOT NULL default '0',
  domain varchar(255) NOT NULL default '',
  authority varchar(255) NOT NULL default '',
  keyword varchar(255) NOT NULL default '',
  description text NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY TYPE (domain(150),authority(150),keyword(150),fk_hierarchy)
) TYPE=MyISAM;

