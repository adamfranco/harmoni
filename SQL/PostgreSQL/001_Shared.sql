-- /**
-- shared_property and shared_properties no longer have any true use, they are 
-- in here for backward compatibility but should ultimately be removed--BG 5/19/2005

-- @package harmoni.osid_v2.shared
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: 001_Shared.sql,v 1.1 2007/09/12 13:02:10 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `type`
-- 

CREATE TABLE type (
  type_id SERIAL NOT NULL,
  type_domain varchar(255) NOT NULL default '',
  type_authority varchar(255) NOT NULL default '',
  type_keyword varchar(255) NOT NULL default '',
  type_description text
);

ALTER TABLE ONLY type
	ADD CONSTRAINT type_primary_key PRIMARY KEY (type_id);

ALTER TABLE ONLY type
	ADD CONSTRAINT type_domain_key UNIQUE (type_domain, type_authority, type_keyword);

CREATE INDEX type_domain_index ON type (type_domain);
CREATE INDEX type_authority_index ON type (type_authority);
CREATE INDEX type_keyword_index ON type (type_keyword);

-- --------------------------------------------------------

-- 
-- Table structure for table `shared_properties`
-- 

CREATE TABLE shared_properties (
  id SERIAL NOT NULL,
  fk_type integer NOT NULL default '0'
);

ALTER TABLE ONLY shared_properties
	ADD CONSTRAINT shared_properties_primary_key PRIMARY KEY (id);
    
ALTER TABLE ONLY shared_properties
	ADD CONSTRAINT shared_properties_fk_type_fkey FOREIGN KEY (fk_type) REFERENCES "type"(type_id) ON UPDATE CASCADE ON DELETE CASCADE;

-- --------------------------------------------------------

-- 
-- Table structure for table `shared_property`
-- 

CREATE TABLE shared_property (
  fk_properties SERIAL NOT NULL,
  property_key varchar(255) NOT NULL default '',
  property_value text NOT NULL
);

ALTER TABLE ONLY shared_property
	ADD CONSTRAINT shared_property_primary_key PRIMARY KEY (fk_properties, property_key);

ALTER TABLE ONLY shared_property
	ADD CONSTRAINT shared_property_fk_properties_fkey FOREIGN KEY (fk_properties) REFERENCES "shared_properties"(id) ON UPDATE CASCADE ON DELETE CASCADE;
