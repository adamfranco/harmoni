-- /**
-- @package harmoni.sets
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: Sets.sql,v 1.1 2007/09/11 19:06:30 adamfranco Exp $
-- */
-- --------------------------------------------------------

-- 
-- Table structure for table `sets`
-- 

CREATE TABLE sets (
  id varchar(150) NOT NULL default '0',
  item_id varchar(150) NOT NULL default '0',
  item_order int(10) unsigned NOT NULL default '0',
  KEY `set_item_index` (`id`,`item_id`)
) 
CHARACTER SET utf8
ENGINE=InnoDB;