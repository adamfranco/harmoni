# phpMyAdmin SQL Dump
# version 2.5.6
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Jun 03, 2004 at 12:36 PM
# Server version: 3.23.56
# PHP Version: 4.3.2
# 
# Database : `doboHarmoniTest`
# 

# --------------------------------------------------------

#
# Table structure for table `hierarchy`
#

CREATE TABLE hierarchy (
  hierarchy_id int(10) unsigned NOT NULL default '0',
  hierarchy_display_name varchar(255) NOT NULL default '',
  hierarchy_description text NOT NULL,
  hierarchy_multiparent enum('0','1') NOT NULL default '1',
  PRIMARY KEY  (hierarchy_id),
  KEY hierarchy_display_name (hierarchy_display_name),
  KEY hierarchy_multiparent (hierarchy_multiparent)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `j_node_node`
#

CREATE TABLE j_node_node (
  fk_parent int(10) NOT NULL default '0',
  fk_child int(10) NOT NULL default '0',
  PRIMARY KEY  (fk_parent,fk_child),
  KEY fk_parent (fk_parent),
  KEY fk_child (fk_child)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `node`
#

CREATE TABLE node (
  node_id int(10) unsigned NOT NULL default '0',
  node_display_name varchar(255) NOT NULL default '',
  node_description text NOT NULL,
  fk_hierarchy int(10) unsigned NOT NULL default '0',
  fk_type int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (node_id),
  KEY node_display_name (node_display_name),
  KEY fk_hierarchy (fk_hierarchy),
  KEY fk_type (fk_type)
) TYPE=MyISAM;
