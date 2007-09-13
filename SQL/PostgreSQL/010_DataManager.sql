-- /**
-- @package harmoni.datamanager
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: 010_DataManager.sql,v 1.2 2007/09/13 16:04:16 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `dm_blob`
-- 
-- Using 'bytea' data type since PostgreSQL doesn't support the BLOB type. Not sure if this will work or not.
-- 

CREATE TABLE dm_blob (
  id varchar(75) NOT NULL,
  data bytea NOT NULL
);

ALTER TABLE ONLY dm_blob
	ADD CONSTRAINT dm_blob_primary_key PRIMARY KEY (id);

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_boolean`
-- 

CREATE TABLE dm_boolean (
  id varchar(75) NOT NULL,
  data smallint NOT NULL
);

ALTER TABLE ONLY dm_boolean
	ADD CONSTRAINT dm_boolean_primary_key PRIMARY KEY (id);

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_float`
-- 

CREATE TABLE dm_float (
  id varchar(75) NOT NULL,
  data double precision NOT NULL
);

ALTER TABLE ONLY dm_float
	ADD CONSTRAINT db_float_primary_key PRIMARY KEY (id);

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_fuzzydate`
-- 

CREATE TABLE dm_fuzzydate (
  id varchar(75) NOT NULL,
  mean bigint NOT NULL,
  range bigint NOT NULL,
  string varchar(255) default NULL
);

ALTER TABLE ONLY dm_fuzzydate
	ADD CONSTRAINT db_fuzzydate_primary_key PRIMARY KEY (id);

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_integer`
-- 

CREATE TABLE dm_integer (
  id varchar(75) NOT NULL,
  data INTEGER NOT NULL
);

ALTER TABLE ONLY dm_integer
	ADD CONSTRAINT db_integer_primary_key PRIMARY KEY (id);

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_okitype`
-- 

CREATE TABLE dm_okitype (
  id varchar(75) NOT NULL,
  domain varchar(255) NOT NULL,
  authority varchar(255) NOT NULL,
  keyword varchar(255) NOT NULL
);

ALTER TABLE ONLY dm_okitype
	ADD CONSTRAINT db_okitype_primary_key PRIMARY KEY (id);

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_schema`
-- 

CREATE TABLE dm_schema (
  id varchar(255) NOT NULL,
  displayname varchar(100) NOT NULL,
  description text NOT NULL,
  revision int NOT NULL default '0',
  active smallint NOT NULL default '1',
  other_params text
);

ALTER TABLE ONLY dm_schema
	ADD CONSTRAINT dm_schema_primary_key PRIMARY KEY (id);

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_schema_field`
-- 

CREATE TABLE dm_schema_field (
  id varchar(255) NOT NULL,
  fk_schema varchar(255) NOT NULL,
  name varchar(255) NOT NULL default '',
  mult smallint NOT NULL default '0',
  fieldtype varchar(255) NOT NULL default '',
  active smallint NOT NULL default '0',
  required smallint NOT NULL default '0',
  description text NOT NULL
);

ALTER TABLE ONLY dm_schema_field
	ADD CONSTRAINT dm_schema_field_primary_key PRIMARY KEY (id);

ALTER TABLE ONLY dm_schema_field
	ADD CONSTRAINT dm_schema_field_fk_schema_fkey FOREIGN KEY (fk_schema) REFERENCES "dm_schema"(id) ON UPDATE CASCADE ON DELETE CASCADE;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_record`
-- 

CREATE TABLE dm_record (
  id varchar(75) NOT NULL,
  fk_schema varchar(255) NOT NULL,
  created timestamp with time zone NOT NULL default CURRENT_TIMESTAMP,
  ver_control smallint NOT NULL default '0'
);


ALTER TABLE ONLY dm_record
	ADD CONSTRAINT db_record_primary_key PRIMARY KEY (id);

ALTER TABLE ONLY dm_record
	ADD CONSTRAINT dm_record_fk_schema_fkey FOREIGN KEY (fk_schema) REFERENCES "dm_schema"(id) ON UPDATE CASCADE ON DELETE CASCADE;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_record_field`
-- 

CREATE TABLE dm_record_field (
  id varchar(75) NOT NULL,
  fk_record varchar(75) NOT NULL,
  fk_schema_field varchar(255) NOT NULL,
  value_index int NOT NULL default '0',
  fk_data varchar(75) NOT NULL,
  active smallint NOT NULL default '0',
  modified timestamp with time zone NOT NULL default CURRENT_TIMESTAMP
);

ALTER TABLE ONLY dm_record_field
	ADD CONSTRAINT dm_record_field_primary_key PRIMARY KEY (id);

ALTER TABLE ONLY dm_record_field
	ADD CONSTRAINT dm_record_field_fk_record_fkey FOREIGN KEY (fk_record) REFERENCES "dm_record"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY dm_record_field
	ADD CONSTRAINT dm_record_field_fk_schema_field_fkey FOREIGN KEY (fk_schema_field) REFERENCES "dm_schema_field"(id) ON UPDATE CASCADE ON DELETE CASCADE;

CREATE INDEX dm_record_field_active_index ON dm_record_field (active);

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_record_set`
-- 

CREATE TABLE dm_record_set (
  id varchar(75) NOT NULL,
  fk_record varchar(75) NOT NULL
);

ALTER TABLE ONLY dm_record_set
	ADD CONSTRAINT dm_record_set_primary_key PRIMARY KEY (id, fk_record);

ALTER TABLE ONLY dm_record_set
	ADD CONSTRAINT dm_record_set_fk_record_fkey FOREIGN KEY (fk_record) REFERENCES "dm_record"(id) ON UPDATE CASCADE ON DELETE CASCADE;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_shortstring`
-- 

CREATE TABLE dm_shortstring (
  id varchar(75) NOT NULL,
  data varchar(255) NOT NULL
);

ALTER TABLE ONLY dm_shortstring
	ADD CONSTRAINT db_shortstring_primary_key PRIMARY KEY (id);

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_string`
-- 

CREATE TABLE dm_string (
  id varchar(75) NOT NULL,
  data text NOT NULL
);

ALTER TABLE ONLY dm_string
	ADD CONSTRAINT db_string_primary_key PRIMARY KEY (id);

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_tag`
-- 

CREATE TABLE dm_tag (
  id varchar(75) NOT NULL,
  fk_record varchar(75) NOT NULL,
  date timestamp with time zone NOT NULL default CURRENT_TIMESTAMP
);

ALTER TABLE ONLY dm_tag
	ADD CONSTRAINT dm_tag_primary_key PRIMARY KEY (id);

ALTER TABLE ONLY dm_tag
	ADD CONSTRAINT dm_tag_fk_record_fkey FOREIGN KEY (fk_record) REFERENCES "dm_record"(id) ON UPDATE CASCADE ON DELETE CASCADE;

CREATE INDEX dm_tag_date_index ON dm_tag (date);

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_tag_map`
-- 

CREATE TABLE dm_tag_map (
  fk_tag varchar(75) NOT NULL,
  fk_record_field varchar(75) NOT NULL
);

ALTER TABLE ONLY dm_tag_map
	ADD CONSTRAINT dm_tag_map_fk_tag_fkey FOREIGN KEY (fk_tag) REFERENCES "dm_tag"(id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY dm_tag_map
	ADD CONSTRAINT dm_tag_map_fk_record_field_fkey FOREIGN KEY (fk_record_field) REFERENCES "dm_record_field"(id) ON UPDATE CASCADE ON DELETE CASCADE;

-- --------------------------------------------------------

-- 
-- Table structure for table `dm_time`
-- 


CREATE TABLE dm_time (
  id varchar(75) NOT NULL,
  jdn bigint NOT NULL,
  seconds int NOT NULL default '0'
);

ALTER TABLE ONLY dm_time
	ADD CONSTRAINT db_time_primary_key PRIMARY KEY (id);

CREATE INDEX dm_time_jdn_index ON dm_time (jdn);
CREATE INDEX dm_time_jdn_sec_index ON dm_time (jdn, seconds);

        