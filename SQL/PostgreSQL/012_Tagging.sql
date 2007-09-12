-- /**
-- @package harmoni.tagging
--
-- @copyright Copyright &copy; 2007, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: 012_Tagging.sql,v 1.1 2007/09/12 21:10:41 adamfranco Exp $
-- */
-- --------------------------------------------------------
-- --------------------------------------------------------

-- 
-- Table structure for table tag_item
-- 

CREATE TABLE tag_item (
  db_id SERIAL NOT NULL,
  id varchar(255) NOT NULL,
  system varchar(20) NOT NULL,
  display_name varchar(255) default NULL,
  description text
);

ALTER TABLE ONLY tag_item
	ADD CONSTRAINT tag_item_primary_key PRIMARY KEY (db_id);

CREATE INDEX tag_item_id_index ON tag_item (id);
CREATE INDEX tag_item_system_index ON tag_item (system);

-- --------------------------------------------------------

-- 
-- Table structure for table tag
-- 

CREATE TABLE tag (
  id SERIAL NOT NULL,
  value varchar(50) NOT NULL,
  user_id varchar(100) NOT NULL,
  tstamp timestamp with time zone NOT NULL default CURRENT_TIMESTAMP,
  fk_item INTEGER NOT NULL
);

ALTER TABLE ONLY tag
	ADD CONSTRAINT tag_primary_key PRIMARY KEY (id);

ALTER TABLE ONLY tag
	ADD CONSTRAINT tag_fk_item_fkey FOREIGN KEY (fk_item) REFERENCES "tag_item"(db_id) ON UPDATE CASCADE ON DELETE CASCADE;

CREATE INDEX tag_user_id_index ON tag (user_id);
CREATE INDEX tag_tstamp_index ON tag (tstamp);

-- --------------------------------------------------------

-- 
-- Table structure for table tag_part_map
-- 
-- Used for tag auto-generation
-- 

CREATE TABLE tag_part_map (
  fk_repository varchar(100) NOT NULL,
  fk_partstruct varchar(150) NOT NULL
);

CREATE INDEX tag_part_map_fk_repository_index ON tag_part_map (fk_repository);
CREATE INDEX tag_part_map_fk_partstruct_index ON tag_part_map (fk_partstruct);
