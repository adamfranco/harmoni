-- /**
-- @package harmoni.osid_v2.repository
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: 011_DigitalRepository.sql,v 1.1 2007/09/12 21:10:41 adamfranco Exp $
-- */
-- --------------------------------------------------------
CREATE LANGUAGE plpgsql;

-- 
-- Table structure for table dr_asset_info
-- 

CREATE TABLE dr_asset_info (
  asset_id varchar(75) NOT NULL,
  effective_date timestamp with time zone default NULL,
  expiration_date timestamp with time zone default NULL,
  create_timestamp timestamp with time zone NOT NULL default CURRENT_TIMESTAMP,
  creator varchar(75) default NULL,
  modify_timestamp timestamp NOT NULL default CURRENT_TIMESTAMP
);

ALTER TABLE ONLY dr_asset_info
	ADD CONSTRAINT dr_asset_info_primary_key PRIMARY KEY (asset_id);

create function update_modify_timestamp() returns trigger as $$begin new.modify_timestamp := now(); return new; end;$$ language plpgsql;
create trigger dr_asset_info_update_modify  before update on dr_asset_info for each row execute procedure update_modify_timestamp();

-- --------------------------------------------------------

-- 
-- Table structure for table dr_asset_record
-- 

CREATE TABLE dr_asset_record (
  fk_asset varchar(75) NOT NULL,
  fk_record varchar(75) NOT NULL,
  structure_id varchar(75) NOT NULL
);

ALTER TABLE ONLY dr_asset_record
	ADD CONSTRAINT dr_asset_record_primary_key PRIMARY KEY (structure_id, fk_asset, fk_record);


-- --------------------------------------------------------

-- 
-- Table structure for table dr_mime_type
-- 

CREATE TABLE dr_mime_type (
  id SERIAL NOT NULL,
  type varchar(255) NOT NULL default ''
);

ALTER TABLE ONLY dr_mime_type
	ADD CONSTRAINT dr_mime_type_primary_key PRIMARY KEY (id);

-- --------------------------------------------------------

-- 
-- Table structure for table dr_file
-- 

CREATE TABLE dr_file (
  id varchar(75) NOT NULL,
  filename varchar(255) NOT NULL default '',
  fk_mime_type int default NULL,
  size int NOT NULL default '0',
  width int default NULL,
  height int default NULL,
  mod_time timestamp with time zone NOT NULL default CURRENT_TIMESTAMP
);

ALTER TABLE ONLY dr_file
	ADD CONSTRAINT dr_file_primary_key PRIMARY KEY (id);

ALTER TABLE ONLY dr_file
	ADD CONSTRAINT dr_file_fk_mime_type_fkey FOREIGN KEY (fk_mime_type) REFERENCES "dr_mime_type"(id) ON UPDATE CASCADE ON DELETE RESTRICT;

create function update_mod_time() returns trigger as $$begin new.mod_time := now(); return new; end;$$ language plpgsql;
create trigger dr_file_update_modify  before update on dr_file for each row execute procedure update_modify_timestamp();

-- --------------------------------------------------------

-- 
-- Table structure for table dr_file_data
-- 
-- This should maybe be done using a Large Object (LOB), but I'm not sure.
-- 

CREATE TABLE dr_file_data (
  fk_file varchar(75) NOT NULL,
  data bytea NOT NULL
);

ALTER TABLE ONLY dr_file_data
	ADD CONSTRAINT dr_file_data_primary_key PRIMARY KEY (fk_file);

ALTER TABLE ONLY dr_file_data
	ADD CONSTRAINT dr_file_data_fk_file_fkey FOREIGN KEY (fk_file) REFERENCES "dr_file"(id) ON UPDATE CASCADE ON DELETE CASCADE;

-- --------------------------------------------------------

-- 
-- Table structure for table dr_type
-- 

CREATE TABLE dr_type (
  type_id SERIAL NOT NULL,
  type_domain varchar(100) NOT NULL,
  type_authority varchar(100) NOT NULL,
  type_keyword varchar(100) NOT NULL,
  type_description text NOT NULL
);

ALTER TABLE ONLY dr_type
	ADD CONSTRAINT dr_type_primary_key PRIMARY KEY (type_id);

ALTER TABLE ONLY dr_type
	ADD CONSTRAINT dr_type_unique_key UNIQUE (type_domain, type_authority, type_keyword);


-- --------------------------------------------------------

-- 
-- Table structure for table dr_repository_type
-- 

CREATE TABLE dr_repository_type (
  repository_id varchar(75) NOT NULL,
  fk_dr_type int NOT NULL
);

ALTER TABLE ONLY dr_repository_type
	ADD CONSTRAINT dr_repository_type_primary_key PRIMARY KEY (repository_id);

ALTER TABLE ONLY dr_repository_type
	ADD CONSTRAINT dr_repository_type_fk_dr_type_fkey FOREIGN KEY (fk_dr_type) REFERENCES "dr_type"(type_id) ON UPDATE CASCADE ON DELETE RESTRICT;

-- --------------------------------------------------------

-- 
-- Table structure for table dr_thumbnail
-- 

CREATE TABLE dr_thumbnail (
  fk_file varchar(75) NOT NULL,
  fk_mime_type int default NULL,
  data bytea NOT NULL,
  width int default NULL,
  height int default NULL
);

ALTER TABLE ONLY dr_thumbnail
	ADD CONSTRAINT dr_thumbnail_primary_key PRIMARY KEY (fk_file);

ALTER TABLE ONLY dr_thumbnail
	ADD CONSTRAINT dr_thumbnail_fk_file_fkey FOREIGN KEY (fk_file) REFERENCES "dr_file"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY dr_thumbnail
	ADD CONSTRAINT dr_thumbnail_fk_mime_type_fkey FOREIGN KEY (fk_mime_type) REFERENCES "dr_mime_type"(id) ON UPDATE CASCADE ON DELETE RESTRICT;

-- --------------------------------------------------------

-- 
-- Table structure for table dr_resized_cache
--
-- This table is use by polyphony.modules.repository
-- 

CREATE TABLE dr_resized_cache (
  fk_file varchar(75) NOT NULL,
  size int NOT NULL default '0',
  websafe BOOLEAN NOT NULL default '0',
  cache_time timestamp with time zone NOT NULL default CURRENT_TIMESTAMP,
  fk_mime_type int default NULL,
  data bytea NOT NULL
);

ALTER TABLE ONLY dr_resized_cache
	ADD CONSTRAINT dr_resized_cache_primary_key PRIMARY KEY (fk_file, size, websafe);

ALTER TABLE ONLY dr_resized_cache
	ADD CONSTRAINT dr_resized_cache_fk_file_fkey FOREIGN KEY (fk_file) REFERENCES "dr_file"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY dr_resized_cache
	ADD CONSTRAINT dr_resized_cache_fk_mime_type_fkey FOREIGN KEY (fk_mime_type) REFERENCES "dr_mime_type"(id) ON UPDATE CASCADE ON DELETE RESTRICT;

create function update_cache_time() returns trigger as $$begin new.cache_time := now(); return new; end;$$ language plpgsql;
create trigger dr_resized_cache  before update on dr_resized_cache for each row execute procedure update_cache_time();

-- --------------------------------------------------------

-- 
-- Table structure for table dr_authoritative_values
-- 
-- This table is used by the part structure to maintain authority lists.
-- 

CREATE TABLE dr_authoritative_values (
  fk_partstructure varchar(100) NOT NULL,
  fk_repository varchar(100) NOT NULL,
  value varchar(240) NOT NULL
);

CREATE INDEX dr_authoritative_values_index ON dr_authoritative_values (fk_partstructure,fk_repository);


-- --------------------------------------------------------

-- 
-- Table structure for table dr_file_url
-- 

CREATE TABLE dr_file_url (
  fk_file varchar(75) NOT NULL,
  url text NOT NULL
);

ALTER TABLE ONLY dr_file_url
	ADD CONSTRAINT dr_file_url_primary_key PRIMARY KEY (fk_file);

ALTER TABLE ONLY dr_file_url
	ADD CONSTRAINT dr_file_url_fk_file_fkey FOREIGN KEY (fk_file) REFERENCES "dr_file"(id) ON UPDATE CASCADE ON DELETE CASCADE;
