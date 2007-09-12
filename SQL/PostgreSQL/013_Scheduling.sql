-- /**
-- @package harmoni.osid_v2.scheduling
-- 
-- 
-- @copyright Copyright &copy; 2006, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
-- 
-- @version $Id: 013_Scheduling.sql,v 1.1 2007/09/12 21:10:41 adamfranco Exp $
-- */
-- --------------------------------------------------------
-- 
-- Table structure for table sc_commit_stat_type
-- 
-- This table contains various types of AgentCommitment statuses

CREATE TABLE sc_commit_stat_type (
  id SERIAL NOT NULL,
  keyword varchar(255) default NULL,
  authority varchar(255) default NULL,
  domain varchar(255) default NULL,
  description text,
  PRIMARY KEY  (id)
);

--
-- This table contains various types of ScheduleItem status
--
CREATE TABLE sc_item_stat_type (
  id SERIAL NOT NULL,
  keyword varchar(255) default NULL,
  authority varchar(255) default NULL,
  domain varchar(255) default NULL,
  description text,
  PRIMARY KEY  (id)
);

-- 
-- Table structure for table sc_item
-- 

CREATE TABLE sc_item (
  id varchar(170) NOT NULL,
  name varchar(255) default NULL,
  description text,
  start bigint default NULL,
  "end" bigint default NULL,
  fk_sc_item_stat_type INTEGER NOT NULL,
  master_id varchar(170) default NULL,
  fk_creator_id varchar(170) default NULL,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY sc_item
	ADD CONSTRAINT sc_item_fk_stat_type_fkey FOREIGN KEY (fk_sc_item_stat_type) REFERENCES "sc_item_stat_type"(id) ON UPDATE CASCADE ON DELETE CASCADE;

CREATE INDEX sc_item_index ON sc_item (start,"end",fk_sc_item_stat_type,master_id);

-- 
-- Table structure for table sc_commit
-- This table holds the agents that are commited to various Sch
--

CREATE TABLE sc_commit (
  id SERIAL NOT NULL,
  fk_agent_id varchar(170) default NULL,
  fk_sc_commit_stat_type INTEGER NOT NULL,
  fk_sc_item varchar(170) NOT NULL,
  PRIMARY KEY  (id)
);

ALTER TABLE ONLY sc_commit
	ADD CONSTRAINT sc_commit_fk_stat_type_fkey FOREIGN KEY (fk_sc_commit_stat_type) REFERENCES "sc_commit_stat_type"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY sc_commit
	ADD CONSTRAINT sc_commit_fk_item_fkey FOREIGN KEY (fk_sc_item) REFERENCES "sc_item"(id) ON UPDATE CASCADE ON DELETE CASCADE;


CREATE INDEX sc_commit_index ON sc_commit (fk_sc_commit_stat_type,fk_sc_item);

