CREATE TABLE sets (
  id int(11) NOT NULL default '0',
  item_id int(11) NOT NULL default '0',
  item_order int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (item_id,id)
) TYPE=MyISAM;