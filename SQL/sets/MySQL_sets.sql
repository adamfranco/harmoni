-- /**
-- @package harmoni.sets
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: MySQL_sets.sql,v 1.4 2005/04/20 19:39:50 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `sets`
-- 

CREATE TABLE sets (
  id varchar(255) NOT NULL default '0',
  item_id varchar(255) NOT NULL default '0',
  item_order int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id(166),item_id(166))
) TYPE=MyISAM;