-- /**
-- @package harmoni.osid_v2.authorization
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: 005_AuthZ.sql,v 1.1 2007/09/12 13:02:12 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `az_function`
-- 

CREATE TABLE az_function (
  function_id varchar(75) NOT NULL default '0',
  function_reference_name varchar(255) NOT NULL default '',
  function_description text NOT NULL,
  fk_qualifier_hierarchy varchar(75) NOT NULL default '0',
  fk_type integer NOT NULL default '0'
);

ALTER TABLE ONLY az_function
	ADD CONSTRAINT az_function_primary_key PRIMARY KEY (function_id);

CREATE INDEX fk_qualifier_hierarchy_index ON az_function (fk_qualifier_hierarchy);

ALTER TABLE ONLY az_function
	ADD CONSTRAINT az_function_fk_type_fkey FOREIGN KEY (fk_type) REFERENCES "type"(type_id) ON UPDATE CASCADE ON DELETE CASCADE;	


-- --------------------------------------------------------

-- 
-- Table structure for table `az_authorization`
-- 

CREATE TABLE az_authorization (
  authorization_id varchar(75) NOT NULL default '0',
  fk_agent varchar(150) NOT NULL default '0',
  fk_function varchar(75) NOT NULL default '0',
  fk_qualifier varchar(75) NOT NULL default '0',
  authorization_effective_date timestamp with time zone default NULL,
  authorization_expiration_date timestamp with time zone default NULL
);

ALTER TABLE ONLY az_authorization
	ADD CONSTRAINT az_authorization_primary_key PRIMARY KEY (authorization_id);

ALTER TABLE ONLY az_authorization
	ADD CONSTRAINT az_authorization_fk_function_fkey FOREIGN KEY (fk_function) REFERENCES "az_function"(function_id) ON UPDATE CASCADE ON DELETE CASCADE;

CREATE INDEX fk_qualifier_id_index ON az_authorization (fk_qualifier);

