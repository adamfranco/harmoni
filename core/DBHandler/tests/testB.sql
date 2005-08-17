-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Aug 17, 2005 at 03:59 PM
-- Server version: 4.0.18
-- PHP Version: 4.3.11
-- 
-- Database: `testB`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `table1`
-- 

DROP TABLE IF EXISTS `table1`;
CREATE TABLE `table1` (
  `name` int(10) unsigned NOT NULL auto_increment,
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`name`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `table1`
-- 

INSERT INTO `table1` VALUES (1, 'bob');
INSERT INTO `table1` VALUES (2, 'alice');

-- --------------------------------------------------------

-- 
-- Table structure for table `table2`
-- 

DROP TABLE IF EXISTS `table2`;
CREATE TABLE `table2` (
  `name` int(10) unsigned NOT NULL auto_increment,
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`name`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `table2`
-- 

