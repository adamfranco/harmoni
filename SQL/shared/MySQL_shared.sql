# phpMyAdmin MySQL-Dump
# version 2.3.3pl1
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jan 14, 2004 at 05:04 PM
# Server version: 3.23.56
# PHP Version: 4.3.2
# Database : `hierarchyManager`
# --------------------------------------------------------

#
# Table structure for table `harmoni_id`
#

CREATE TABLE harmoni_id (
  harmoni_id_number bigint(20) unsigned NOT NULL auto_increment,
  harmoni_id_domain varchar(255) NOT NULL default '',
  harmoni_id_authority varchar(255) NOT NULL default '',
  harmoni_id_keyword varchar(255) NOT NULL default '',
  PRIMARY KEY  (harmoni_id_number)
) TYPE=MyISAM;

