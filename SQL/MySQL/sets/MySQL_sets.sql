-- /**
-- @package harmoni.sets
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: MySQL_sets.sql,v 1.1 2007/09/11 18:19:27 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `sets`
-- 

CREATE TABLE sets (
  id varchar(150) NOT NULL default '0',
  item_id varchar(150) NOT NULL default '0',
  item_order int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id,item_id)
) 
CHARACTER SET utf8
TYPE=InnoDB;