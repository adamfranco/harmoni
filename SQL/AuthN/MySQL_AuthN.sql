CREATE TABLE authn_mapping (
  agent_id int(10) unsigned NOT NULL default '0',
  system_name varchar(255) NOT NULL default '',
  type_domain varchar(255) NOT NULL default '',
  type_authority varchar(255) NOT NULL default '',
  type_keyword varchar(255) NOT NULL default '',
  PRIMARY KEY  (agent_id,system_name),
  KEY agent_id (agent_id),
  KEY system_name (system_name)
) TYPE=MyISAM;
