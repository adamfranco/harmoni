-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Mar 03, 2006 at 12:16 PM
-- Server version: 4.1.14
-- PHP Version: 4.4.2
-- 
-- Database: `afranco_segue2`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `log_agent`
-- 

CREATE TABLE log_agent (
  fk_entry varchar(70) NOT NULL default '',
  fk_agent varchar(70) NOT NULL default ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='These are the agents involved in a particular log event';

-- --------------------------------------------------------

-- 
-- Table structure for table `log_entry`
-- 

CREATE TABLE log_entry (
  log_name varchar(70) NOT NULL default '',
  id int(10) unsigned NOT NULL auto_increment,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  fk_format_type varchar(70) NOT NULL default '',
  fk_priority_type varchar(70) NOT NULL default '',
  category varchar(50) NOT NULL default 'UNKNOWN',
  description text NOT NULL,
  backtrace text,
  PRIMARY KEY  (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Used by the OSID Logging Manager';

-- --------------------------------------------------------

-- 
-- Table structure for table `log_node`
-- 

CREATE TABLE log_node (
  fk_entry varchar(70) NOT NULL default '',
  fk_node varchar(70) NOT NULL default ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='These are the nodes involved in a particular log event';

-- --------------------------------------------------------

-- 
-- Table structure for table `log_type`
-- 

CREATE TABLE log_type (
  id int(11) NOT NULL auto_increment,
  domain varchar(100) NOT NULL default '',
  authority varchar(100) NOT NULL default '',
  keyword varchar(100) NOT NULL default '',
  description text NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY uniq (domain,authority,keyword)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
