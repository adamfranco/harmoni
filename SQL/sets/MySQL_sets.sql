-- /**
-- @package harmoni.sets
--
-- @copyright Copyright &copy; 2005, Middlebury College
-- @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
--
-- @version $Id: MySQL_sets.sql,v 1.3 2005/04/07 15:12:30 adamfranco Exp $
-- */
-- --------------------------------------------------------

CREATE TABLE sets (
  id int(11) NOT NULL default '0',
  item_id int(11) NOT NULL default '0',
  item_order int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (item_id,id)
) TYPE=MyISAM;