-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jun 13, 2006 at 05:10 PM
-- Server version: 4.1.14
-- PHP Version: 4.4.2
-- 
-- Database: `mdb_concerto`
-- 
-- --------------------------------------------------------

-- 
-- Table structure for table `log_type`
-- 

CREATE TABLE log_type (
  id SERIAL NOT NULL,
  "domain" varchar(100) NOT NULL default '',
  authority varchar(100) NOT NULL default '',
  keyword varchar(100) NOT NULL default '',
  description text NOT NULL
);

ALTER TABLE ONLY log_type
	ADD CONSTRAINT log_type_primary_key PRIMARY KEY (id);
	
ALTER TABLE ONLY log_type
	ADD CONSTRAINT log_type_domain_key UNIQUE ("domain", authority, keyword);

-- --------------------------------------------------------

-- 
-- Table structure for table `log_entry`
-- 

CREATE TABLE log_entry (
  log_name varchar(70) NOT NULL default '',
  id SERIAL NOT NULL,
  "timestamp" timestamp with time zone NOT NULL default CURRENT_TIMESTAMP,
  fk_format_type INTEGER NOT NULL,
  fk_priority_type INTEGER NOT NULL,
  category varchar(50) NOT NULL default 'UNKNOWN',
  description text NOT NULL,
  backtrace text
);

ALTER TABLE ONLY log_entry
	ADD CONSTRAINT log_entry_primary_key PRIMARY KEY (id);
	
CREATE INDEX log_entry_name_index ON log_entry (log_name);
CREATE INDEX log_entry_timestamp_index ON log_entry ("timestamp");

ALTER TABLE ONLY log_entry
	ADD CONSTRAINT log_entry_fk_format_type_fkey FOREIGN KEY (fk_format_type) REFERENCES "log_type"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY log_entry
	ADD CONSTRAINT log_entry_fk_priority_type_fkey FOREIGN KEY (fk_priority_type) REFERENCES "log_type"(id) ON UPDATE CASCADE ON DELETE CASCADE;


-- --------------------------------------------------------

-- 
-- Table structure for table `log_agent`
-- 

CREATE TABLE log_agent (
  fk_entry varchar(70) NOT NULL default '',
  fk_agent varchar(70) NOT NULL default ''
);

ALTER TABLE ONLY log_agent
	ADD CONSTRAINT log_agent_primary_key PRIMARY KEY (fk_entry, fk_agent);

ALTER TABLE ONLY log_agent
	ADD CONSTRAINT log_agent_fk_entry_fkey FOREIGN KEY (fk_entry) REFERENCES "log_entry"(id) ON UPDATE CASCADE ON DELETE CASCADE;

-- --------------------------------------------------------

-- 
-- Table structure for table `log_node`
-- 

CREATE TABLE log_node (
  fk_entry varchar(70) NOT NULL default '',
  fk_node varchar(70) NOT NULL default '',
  PRIMARY KEY  (fk_entry,fk_node)
);

ALTER TABLE ONLY log_node
	ADD CONSTRAINT log_node_primary_key PRIMARY KEY (fk_entry, fk_node);

ALTER TABLE ONLY log_node
	ADD CONSTRAINT log_node_fk_entry_fkey FOREIGN KEY (fk_entry) REFERENCES "log_entry"(id) ON UPDATE CASCADE ON DELETE CASCADE;
