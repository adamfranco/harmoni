-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 21, 2006 at 02:08 PM
-- Server version: 4.1.14
-- PHP Version: 4.4.2
-- 
-- Database: gladius_concerto
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table cm_can_stat_type
-- 
-- This table contains various canonical course statuses

CREATE TABLE cm_can_stat_type (
  id SERIAL NOT NULL,
  keyword varchar(255) NOT NULL,
  authority varchar(255) NOT NULL,
  domain varchar(255) NOT NULL,
  description text,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY cm_can_stat_type
	ADD CONSTRAINT cm_can_stat_type_unique UNIQUE (domain, authority, keyword);


-- --------------------------------------------------------

-- 
-- Table structure for table cm_can_type
-- 
-- This table contains various types of canonical courses
--

CREATE TABLE cm_can_type (
  id SERIAL NOT NULL,
  keyword varchar(255) NOT NULL,
  authority varchar(255) NOT NULL,
  domain varchar(255) NOT NULL,
  description text,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY cm_can_type
	ADD CONSTRAINT cm_can_type_unique UNIQUE (domain, authority, keyword);

-- --------------------------------------------------------

-- 
-- Table structure for table cm_enroll_stat_type
-- 
-- This table contains various types of enrollment statuses
--

CREATE TABLE cm_enroll_stat_type (
  id SERIAL NOT NULL,
  keyword varchar(255) NOT NULL,
  authority varchar(255) NOT NULL,
  domain varchar(255) NOT NULL,
  description text,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY cm_enroll_stat_type
	ADD CONSTRAINT cm_enroll_stat_type_unique UNIQUE (domain, authority, keyword);

-- --------------------------------------------------------

-- 
-- Table structure for table cm_offer_stat_type
-- 
-- This table contains various course offering statuses
--

CREATE TABLE cm_offer_stat_type (
  id SERIAL NOT NULL,
  keyword varchar(255) NOT NULL,
  authority varchar(255) NOT NULL,
  domain varchar(255) NOT NULL,
  description text,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY cm_offer_stat_type
	ADD CONSTRAINT cm_offer_stat_type_unique UNIQUE (domain, authority, keyword);

-- --------------------------------------------------------

-- 
-- Table structure for table cm_offer_type
-- 
-- This table contains various types of course offerings
--

CREATE TABLE cm_offer_type (
  id SERIAL NOT NULL,
  keyword varchar(255) NOT NULL,
  authority varchar(255) NOT NULL,
  domain varchar(255) NOT NULL,
  description text,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY cm_offer_type
	ADD CONSTRAINT cm_offer_type_unique UNIQUE (domain, authority, keyword);

-- --------------------------------------------------------

-- 
-- Table structure for table cm_section_stat_type
-- 
-- This table contains various course section statuses
--

CREATE TABLE cm_section_stat_type (
  id SERIAL NOT NULL,
  keyword varchar(255) NOT NULL,
  authority varchar(255) NOT NULL,
  domain varchar(255) NOT NULL,
  description text,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY cm_section_stat_type
	ADD CONSTRAINT cm_section_stat_type_unique UNIQUE (domain, authority, keyword);

-- --------------------------------------------------------

-- 
-- Table structure for table cm_section_type
-- 
-- This table contains various types of course sections
--

CREATE TABLE cm_section_type (
  id SERIAL NOT NULL,
  keyword varchar(255) NOT NULL,
  authority varchar(255) NOT NULL,
  domain varchar(255) NOT NULL,
  description text,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY cm_section_type
	ADD CONSTRAINT cm_section_type_unique UNIQUE (domain, authority, keyword);

-- --------------------------------------------------------

-- 
-- Table structure for table cm_term_type
-- 
-- This table contains various types of terms
--

CREATE TABLE cm_term_type (
  id SERIAL NOT NULL,
  keyword varchar(255) NOT NULL,
  authority varchar(255) NOT NULL,
  domain varchar(255) NOT NULL,
  description text,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY cm_term_type
	ADD CONSTRAINT cm_term_type_unique UNIQUE (domain, authority, keyword);

-- --------------------------------------------------------

-- 
-- Table structure for table cm_assets
-- 
-- This table contains the Assets for offerings and sections
--

CREATE TABLE cm_assets (
  fk_course_id varchar(170) NOT NULL,
  fk_asset_id varchar(170) NOT NULL
);

CREATE INDEX cm_assets_fk_course_id_index ON cm_assets (fk_course_id);

-- --------------------------------------------------------

-- 
-- Table structure for table cm_can
-- 
-- This table holds all of the canonical course listings.
--

CREATE TABLE cm_can (
  id varchar(170) NOT NULL,
  number varchar(170) default NULL,
  credits float default NULL,
  equivalent varchar(170) default NULL,
  fk_cm_can_type varchar(170) default NULL,
  title varchar(255) default NULL,
  fk_cm_can_stat_type varchar(170) default NULL,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY cm_can
	ADD CONSTRAINT cm_can_fk_cm_can_type_fkey FOREIGN KEY (fk_cm_can_type) REFERENCES "cm_can_type"(id) ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE ONLY cm_can
	ADD CONSTRAINT cm_can_fk_cm_stat_type_fkey FOREIGN KEY (fk_cm_stat_type) REFERENCES "cm_stat_type"(id) ON UPDATE CASCADE ON DELETE RESTRICT;


-- --------------------------------------------------------

-- 
-- Table structure for table cm_term
-- 
-- This table stores various terms
--

CREATE TABLE cm_term (
  id varchar(170) NOT NULL,
  name varchar(255) default NULL,
  fk_cm_term_type int default NULL,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY cm_term
	ADD CONSTRAINT cm_term_fk_cm_term_type_fkey FOREIGN KEY (fk_cm_term_type) REFERENCES "cm_term_type"(id) ON UPDATE CASCADE ON DELETE CASCADE;

-- --------------------------------------------------------

-- 
-- Table structure for table cm_section
-- 
-- This table contains course sections
--

CREATE TABLE cm_section (
  id varchar(170) NOT NULL,
  location varchar(255) default NULL,
  schedule varchar(170) default NULL,
  fk_cm_section_type int default NULL,
  fk_cm_section_stat_type int default NULL,
  number varchar(170) default NULL,
  title varchar(255) default NULL,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY cm_section
	ADD CONSTRAINT cm_section_fk_cm_section_type_fkey FOREIGN KEY (fk_cm_section_type) REFERENCES "cm_section_type"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY cm_section
	ADD CONSTRAINT cm_section_fk_cm_section_stat_type_fkey FOREIGN KEY (fk_cm_section_stat_type) REFERENCES "cm_section_stat_type"(id) ON UPDATE CASCADE ON DELETE CASCADE;


-- --------------------------------------------------------

-- 
-- Table structure for table cm_enroll
-- 

CREATE TABLE cm_enroll (
  fk_student_id varchar(170) NOT NULL,
  id SERIAL NOT NULL,
  fk_cm_enroll_stat_type int NOT NULL,
  fk_cm_section varchar(170) NOT NULL,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY cm_enroll
	ADD CONSTRAINT cm_enroll_fk_cm_section_fkey FOREIGN KEY (fk_cm_section) REFERENCES "cm_section"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY cm_enroll
	ADD CONSTRAINT cm_enroll_fk_cm_enroll_stat_type_fkey FOREIGN KEY (fk_cm_enroll_stat_type) REFERENCES "cm_enroll_stat_type"(id) ON UPDATE CASCADE ON DELETE CASCADE;

CREATE INDEX cm_enroll_fk_course_id_index ON cm_enroll (fk_course_id);
CREATE INDEX cm_enroll_fk_student_id_index ON cm_enroll (fk_student_id);

-- --------------------------------------------------------

-- 
-- Table structure for table cm_offer
-- 
-- This table contains all of the course offerings
--

CREATE TABLE cm_offer (
  id varchar(170) NOT NULL default '',
  fk_gr_grade_type varchar(170) default NULL,
  fk_cm_term varchar(170) default NULL,
  fk_cm_offer_stat_type varchar(255) default NULL,
  fk_cm_offer_type varchar(170) default NULL,
  title varchar(255) default NULL,
  number varchar(255) default NULL,
  PRIMARY KEY  (id),
  KEY fk_offer_type (id)
);

-- --------------------------------------------------------

-- 
-- Table structure for table cm_grade_rec
-- 
-- All the grade records for all students and courses
--

CREATE TABLE cm_grade_rec (
  id int(170) NOT NULL auto_increment,
  fk_student_id varchar(170) default NULL,
  fk_cm_offer varchar(170) default NULL,
  name varchar(255) default NULL,
  grade varchar(255) default NULL,
  PRIMARY KEY  (id)
);



-- --------------------------------------------------------

-- 
-- Table structure for table cm_schedule
-- 

CREATE TABLE cm_schedule (
  fk_sc_item varchar(170) default NULL,
  fk_id varchar(170) default NULL,
  KEY fk_id (fk_id)
);



-- --------------------------------------------------------

-- 
-- Table structure for table cm_topics
-- 

CREATE TABLE cm_topics (
  fk_cm_can varchar(170) default NULL,
  topic varchar(255) NOT NULL default '',
  PRIMARY KEY  (topic),
  KEY fk_cm_can (fk_cm_can)
);

-- --------------------------------------------------------
