# phpMyAdmin SQL Dump
# version 2.5.6
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Apr 29, 2004 at 02:33 PM
# Server version: 3.23.56
# PHP Version: 4.3.2
# 
# Database : `themes`
# 

# --------------------------------------------------------

#
# Table structure for table `setting`
#

CREATE TABLE setting (
  fk_theme int(10) unsigned NOT NULL default '0',
  fk_widget_type int(10) unsigned NOT NULL default '0',
  widget_index int(10) unsigned NOT NULL default '0',
  setting_key varchar(255) NOT NULL default '0',
  value varchar(255) default NULL,
  PRIMARY KEY  (fk_theme,fk_widget_type,widget_index,setting_key)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `theme`
#

CREATE TABLE theme (
  id int(10) unsigned NOT NULL default '0',
  class_name varchar(255) NOT NULL default 'SimpleLinesTheme',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `widget_type`
#

CREATE TABLE widget_type (
  id int(10) unsigned NOT NULL auto_increment,
  type varchar(100) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
