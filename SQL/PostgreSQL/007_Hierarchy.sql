-- /**
-- @package harmoni.osid_v2.hierarchy
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: 007_Hierarchy.sql,v 1.2 2007/09/13 16:04:16 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table hierarchy
-- 

CREATE TABLE hierarchy (
  hierarchy_id varchar(75) NOT NULL default '0',
  hierarchy_display_name varchar(255) NOT NULL default '',
  hierarchy_description text NOT NULL,
  hierarchy_multiparent smallint NOT NULL default '1'
);

ALTER TABLE ONLY hierarchy
	ADD CONSTRAINT hierarchy_primary_key PRIMARY KEY (hierarchy_id);


-- --------------------------------------------------------

-- 
-- Table structure for table node
-- 

CREATE TABLE node (
  node_id varchar(75) NOT NULL default '0',
  node_display_name varchar(255) NOT NULL default '',
  node_description text NOT NULL,
  fk_hierarchy varchar(75) NOT NULL default '0',
  fk_type integer NOT NULL default '0',
  az_node_changed timestamp NULL default NULL
);

ALTER TABLE ONLY node
	ADD CONSTRAINT node_primary_key PRIMARY KEY (fk_hierarchy, node_id);

CREATE INDEX node_display_name_index ON node (node_display_name);
CREATE INDEX node_az_node_changed_index ON node (az_node_changed);

ALTER TABLE ONLY node
	ADD CONSTRAINT node_fk_hierarchy_fkey FOREIGN KEY (fk_hierarchy) REFERENCES "hierarchy"(hierarchy_id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY node
	ADD CONSTRAINT node_fk_type_fkey FOREIGN KEY (fk_type) REFERENCES "type"(type_id) ON UPDATE CASCADE ON DELETE CASCADE;

-- --------------------------------------------------------

-- 
-- Table structure for table j_node_node
-- 

CREATE TABLE j_node_node (
  fk_hierarchy varchar(75) NOT NULL default '0',
  fk_parent varchar(75) NOT NULL default '0',
  fk_child varchar(75) NOT NULL default '0'
);

ALTER TABLE ONLY j_node_node
	ADD CONSTRAINT j_node_node_primary_key PRIMARY KEY (fk_parent, fk_child);

ALTER TABLE ONLY j_node_node
	ADD CONSTRAINT j_node_node_fk_parent_fkey FOREIGN KEY (fk_hierarchy, fk_parent) REFERENCES node(fk_hierarchy, node_id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY j_node_node
	ADD CONSTRAINT j_node_node_fk_child_fkey FOREIGN KEY (fk_hierarchy, fk_child) REFERENCES node(fk_hierarchy, node_id) ON UPDATE CASCADE ON DELETE CASCADE;


-- --------------------------------------------------------

-- 
-- Table structure for table node_ancestry
-- 

CREATE TABLE node_ancestry (
  fk_hierarchy varchar(75) NOT NULL default '0',
  fk_node varchar(255) NOT NULL default '',
  fk_ancestor varchar(255) default NULL,
  level integer NOT NULL default '0',
  fk_ancestors_child varchar(255) default NULL
);

ALTER TABLE ONLY node_ancestry
	ADD CONSTRAINT node_ancestry_fk_node_fkey FOREIGN KEY (fk_hierarchy, fk_node) REFERENCES node(fk_hierarchy, node_id) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY node_ancestry
	ADD CONSTRAINT node_ancestry_fk_ancestor_fkey FOREIGN KEY (fk_hierarchy, fk_ancestor) REFERENCES node(fk_hierarchy, node_id) ON UPDATE CASCADE ON DELETE CASCADE;
	
ALTER TABLE ONLY node_ancestry
	ADD CONSTRAINT node_ancestry_fk_ancestors_child_fkey FOREIGN KEY (fk_hierarchy, fk_ancestors_child) REFERENCES node(fk_hierarchy, node_id) ON UPDATE CASCADE ON DELETE CASCADE;
        
