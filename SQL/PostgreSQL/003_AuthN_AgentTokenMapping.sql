-- /**
-- @package harmoni.osid_v2.agentmanagement
-- 
-- 
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
-- 
-- @version $Id: 003_AuthN_AgentTokenMapping.sql,v 1.2 2007/09/13 16:04:16 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `agenttoken_mapping_authntype`
-- 

CREATE TABLE agenttoken_mapping_authntype (
  id SERIAL NOT NULL,
  domain varchar(100) NOT NULL default '',
  authority varchar(100) NOT NULL default '',
  keyword varchar(100) NOT NULL default '',
  description text NOT NULL
);

ALTER TABLE ONLY agenttoken_mapping_authntype
	ADD CONSTRAINT agenttoken_mapping_authntype_primary_key PRIMARY KEY (id);

ALTER TABLE ONLY agenttoken_mapping_authntype
    ADD CONSTRAINT agenttoken_mapping_authntype_domain_key UNIQUE ("domain", authority, keyword);

-- --------------------------------------------------------

-- 
-- Table structure for table `agenttoken_mapping`
-- 

CREATE TABLE agenttoken_mapping (
  agent_id varchar(75) NOT NULL default '0',
  token_identifier varchar(255) NOT NULL default '',
  fk_type INTEGER NOT NULL default '0'
);

ALTER TABLE ONLY agenttoken_mapping
	ADD CONSTRAINT agenttoken_mapping_primary_key PRIMARY KEY (fk_type, token_identifier, agent_id);

ALTER TABLE ONLY agenttoken_mapping
	ADD CONSTRAINT agenttoken_mapping_fk_type_fkey FOREIGN KEY (fk_type) REFERENCES "agenttoken_mapping_authntype"(id) ON UPDATE CASCADE ON DELETE CASCADE;	

CREATE INDEX agenttoken_mapping_agent_id_index ON agenttoken_mapping (agent_id);
CREATE INDEX agenttoken_mapping_token_identifier_index ON agenttoken_mapping (token_identifier);