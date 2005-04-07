-- /**
-- @package harmoni.osid_v2.agentmanagement
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: MySQL_AgentTokenMapping.sql,v 1.2 2005/04/07 15:12:17 adamfranco Exp $
-- */
-- --------------------------------------------------------

CREATE TABLE agenttoken_mapping (
  agent_id int(10) unsigned NOT NULL default '0',
  token_identifier varchar(255) NOT NULL default '',
  fk_type int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (agent_id,token_identifier,fk_type),
  KEY agent_id (agent_id),
  KEY system_name (token_identifier)
) TYPE=MyISAM;


CREATE TABLE agenttoken_mapping_authntype (
  id int(11) NOT NULL auto_increment,
  domain varchar(100) NOT NULL default '',
  authority varchar(100) NOT NULL default '',
  keyword varchar(100) NOT NULL default '',
  description text NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY domain (domain,authority,keyword)
) TYPE=MyISAM;