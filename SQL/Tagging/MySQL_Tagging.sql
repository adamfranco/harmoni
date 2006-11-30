-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Nov 08, 2006 at 03:41 PM
-- Server version: 4.1.14
-- PHP Version: 4.4.2
-- 
-- Database: `afranco_segue2`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `tag`
-- 

CREATE TABLE `tag` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `value` varchar(50) collate utf8_bin NOT NULL default '',
  `user_id` varchar(100) collate utf8_bin NOT NULL default '',
  `tstamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `fk_item` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `value` (`value`,`user_id`,`fk_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tag definitions';

-- --------------------------------------------------------

-- 
-- Table structure for table `tag_item`
-- 

CREATE TABLE `tag_item` (
  `db_id` int(10) unsigned NOT NULL auto_increment,
  `id` varchar(255) collate utf8_bin NOT NULL default '',
  `system` varchar(20) collate utf8_bin NOT NULL default '',
  `display_name` varchar(255) collate utf8_bin default NULL,
  `description` text collate utf8_bin,
  PRIMARY KEY  (`db_id`),
  KEY `id` (`id`),
  KEY `system` (`system`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tagged items';


-- --------------------------------------------------------

-- 
-- Table structure for table `tag_part_map`
-- 

CREATE TABLE tag_part_map (
  fk_repository varchar(100) collate utf8_bin NOT NULL default '',
  fk_partstruct varchar(150) collate utf8_bin NOT NULL default '',
  KEY fk_repository (fk_repository),
  KEY fk_partstruct (fk_partstruct)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Used for tag auto-generation';