-- /**
-- @package harmoni.osid_v2.agent
-- 
-- 
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
-- 
-- @version $Id: 002_Agent.sql,v 1.1 2007/09/12 13:02:10 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- --------------------------------------------------------
-- 
-- Table structure for table agent_properties
-- 

CREATE TABLE agent_properties (
  property_id SERIAL NOT NULL,
  fk_object_id varchar(255) NOT NULL default '0',
  fk_type_id varchar(255) NOT NULL default '',
  property_key varchar(255) NOT NULL default '',
  property_value text NOT NULL
);


ALTER TABLE ONLY agent_properties
	ADD CONSTRAINT agent_properties_primary_key PRIMARY KEY (property_id);

ALTER TABLE ONLY agent_properties
	ADD CONSTRAINT agent_properties_fk_type_id_fkey FOREIGN KEY (fk_type_id) REFERENCES "type"(type_id) ON UPDATE CASCADE ON DELETE CASCADE;	

