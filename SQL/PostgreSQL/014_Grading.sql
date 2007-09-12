-- /**
-- @package harmoni.osid_v2.grading
-- 
-- 
-- @copyright Copyright &copy; 2006, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
-- 
-- @version $Id: 014_Grading.sql,v 1.1 2007/09/12 21:10:41 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table gr_record_type
--
-- This table contains various types of grade records
-- 

CREATE TABLE gr_record_type (
  id SERIAL NOT NULL,
  keyword varchar(255) NOT NULL,
  authority varchar(255) NOT NULL,
  domain varchar(255) NOT NULL,
  description text,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY gr_record_type
	ADD CONSTRAINT gr_record_type_unique_key UNIQUE (domain, authority, keyword);

-- --------------------------------------------------------

-- 
-- Table structure for table gr_scoring_type
-- 
-- This table contains various types of ScoringDefinitions
-- 

CREATE TABLE gr_scoring_type (
  id SERIAL NOT NULL,
  keyword varchar(255) NOT NULL,
  authority varchar(255) NOT NULL,
  domain varchar(255) NOT NULL,
  description text,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY gr_scoring_type
	ADD CONSTRAINT gr_scoring_type_unique_key UNIQUE (domain, authority, keyword);

-- --------------------------------------------------------

-- 
-- Table structure for table gr_grade_type
-- 
-- This table contains various types of grades
--

CREATE TABLE gr_grade_type (
  id SERIAL NOT NULL,
  keyword varchar(255) NOT NULL,
  authority varchar(255) NOT NULL,
  domain varchar(255) NOT NULL,
  description text,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY gr_grade_type
	ADD CONSTRAINT gr_grade_type_unique_key UNIQUE (domain, authority, keyword);

-- --------------------------------------------------------

-- 
-- Table structure for table gr_gradescale_type
-- 
-- This table contains various types of grade scales
--

CREATE TABLE gr_gradescale_type (
  id SERIAL NOT NULL,
  keyword varchar(255) NOT NULL,
  authority varchar(255) NOT NULL,
  domain varchar(255) NOT NULL,
  description text,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY gr_gradescale_type
	ADD CONSTRAINT gr_gradescale_type_unique_key UNIQUE (domain, authority, keyword);

-- --------------------------------------------------------

-- Table structure for table gr_gradable
-- 

CREATE TABLE gr_gradable (
  id varchar(170) NOT NULL,
  fk_gr_scoring_type int NOT NULL,
  fk_gr_grade_type int NOT NULL,
  fk_gr_gradescale_type int NOT NULL,
  description text,
  name varchar(255) default NULL,
  modified_date bigint default NULL,
  fk_modified_by_agent varchar(170) default NULL,
  fk_reference_id varchar(170) default NULL,
  fk_cm_section varchar(170) NOT NULL default '',
  weight int NOT NULL default '0',
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY gr_gradable
	ADD CONSTRAINT gr_gradable_fk_gr_scoring_type_fkey FOREIGN KEY (fk_gr_scoring_type) REFERENCES "gr_scoring_type"(id) ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE ONLY gr_gradable
	ADD CONSTRAINT gr_gradable_fk_gr_grade_type_fkey FOREIGN KEY (fk_gr_grade_type) REFERENCES "gr_grade_type"(id) ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE ONLY gr_gradable
	ADD CONSTRAINT gr_gradable_fk_gr_gradescale_type_fkey FOREIGN KEY (fk_gr_gradescale_type) REFERENCES "gr_gradescale_type"(id) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE INDEX gr_gradable_reference_index ON gr_gradable (fk_reference_id,fk_cm_section);


-- --------------------------------------------------------

-- 
-- Table structure for table gr_record
-- 
-- This table contains all of the GradeRecords
--

CREATE TABLE gr_record (
  id varchar(170) NOT NULL,
  value varchar(255) default NULL,
  fk_gr_gradable varchar(170) NOT NULL,
  fk_agent_id varchar(170) default NULL,
  fk_modified_by_agent varchar(170) default NULL,
  modified_date bigint default NULL,
  fk_gr_record_type int NOT NULL,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY gr_record
	ADD CONSTRAINT gr_record_fk_gr_gradable_fkey FOREIGN KEY (fk_gr_gradable) REFERENCES "gr_gradable"(id) ON UPDATE CASCADE ON DELETE RESTRICT;

ALTER TABLE ONLY gr_record
	ADD CONSTRAINT gr_record_fk_gr_record_type_fkey FOREIGN KEY (fk_gr_record_type) REFERENCES "gr_record_type"(id) ON UPDATE CASCADE ON DELETE RESTRICT;

CREATE INDEX gr_record_fk_agent_id_index ON gr_record (fk_agent_id);

